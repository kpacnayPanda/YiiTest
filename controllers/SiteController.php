<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Repo;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    private const GITHUB_API_URL = 'https://api.github.com/users';

    public function actionIndex()
    {
        $users = [
            new User(['username' => 'kpacnaypanda']),
            new User(['username' => 'Sithell']),
        ];

        $repos = $this->fetchLatestRepos($users);
        return $this->render('index', ['repos' => $repos]);
    }

    private function fetchLatestRepos(array $users): array
    {
        $allRepos = [];
        foreach ($users as $user) {
            $userRepos = $this->fetchRepos($user->username);
            $allRepos = array_merge($allRepos, $userRepos);
        }
        usort($allRepos, fn($a, $b) => strtotime($b['updated_at']) - strtotime($a['updated_at']));
        return array_slice($allRepos, 0, 10);
    }

    private function fetchRepos(string $username): array
    {
        $url = self::GITHUB_API_URL . "/$username/repos";
        $client = new \GuzzleHttp\Client();
        try {
            $response = $client->get($url, [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'User-Agent' => 'Yii2-App',
                ],
            ]);
            $repos = json_decode($response->getBody()->getContents(), true);
            return ArrayHelper::getColumn($repos, function ($repo) {
                return [
                    'login' => $repo['owner']['login'],
                    'name' => $repo['name'],
                    'html_url' => $repo['html_url'],
                    'updated_at' => $repo['updated_at'],
                ];
            });
        } catch (\Exception $e) {
            Yii::error("Ошибка загрузки данных для пользователя $username: " . $e->getMessage());
            return [];
        }
    }
}
