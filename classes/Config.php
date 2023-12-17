<?php

// protected $host = 'localhost';
// protected $username = 'u461943529_Grado';
// protected $password = 'Grado_123';
// protected $database = 'u461943529_Grado';

class Config
{
    private static $config = [
        'mysql' => [
            'host' => 'localhost',
            'user' => 'root',
            'password' => '',
            'database' => 'grade',
            'options' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        ],
        'app' => [
            'name' => 'Grado',
            'url' => 'http://localhost/grado',
            'version' => '1.0.0',
            'debug' => true
        ],
        'mail' => [
            'host' => 'smtp.gmail.com',
            'port' => 587,
            'username' => 'angelnino.ortega.pixel8@gmail.com',
            'password' => 'ztcvbpolateijnbc',
            'from' => 'angelnino.ortega.pixel8@gmail.com',
            'name' => 'Grado'
        ],
        'pages' => [
            'dashboard' => 'dashboard',
            'curriculums' => 'curriculums',
            'curriculum' => 'curriculum',
            'subjects' => 'subjects',
            'subject' => 'subject',
            'students' => 'students',
            'student' => 'student',
            'teachers' => 'teachers',
            'teacher' => 'teacher',
            'courses' => 'courses',
            'course' => 'course',
            'add-grade' => 'add-grade',
            'users' => 'users',
            'profile' => 'profile',
            'logout' => 'logout'
        ]
    ];

    public static function get($path = null)
    {
        if ($path) {
            $config = self::$config;
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }

            return $config;
        }

        return false;
    }

    public static function set($path, $value)
    {
        if ($path) {
            $config = &self::$config;
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (!isset($config[$bit])) {
                    $config[$bit] = [];
                }

                $config = &$config[$bit];
            }

            $config = $value;
            return true;
        }

        return false;
    }
}
