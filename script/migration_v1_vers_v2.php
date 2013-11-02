<?php


$default = require __DIR__ . '/../app/config/database.php';

$env = '';
$envSpecific = array();
if (isset($argv[1])) {
    $parts = explode('=', $argv[1]);
    if ($parts[0] == '--env') {
        if ($parts[1] != '' && file_exists(__DIR__ . '/../app/config/'.$parts[1].'/database.php')) {
            $envSpecific = require __DIR__ . '/../app/config/'.$parts[1].'/database.php';
        }
    }
}
$id_db = array_merge($default, $envSpecific);
$connexionInfos = $id_db['connections'][$id_db['default']];

if (php_sapi_name() === 'cli') {
    DEFINE('NL', PHP_EOL);
    DEFINE('FORCE_SPACE', ' ');
} else {
    DEFINE('NL', '<br />');
    DEFINE('FORCE_SPACE', '&nbsp;');
    echo "<pre>";
}


$user = $connexionInfos['username'];
$password = $connexionInfos['password'];
$dsnV3 = 'mysql:dbname=laravelfr;host=localhost';
$dsnV4 = 'mysql:dbname=laravelfr4;host=localhost';

$dbv3 = new PDO($dsnV3, $user, $password);
$dbv4 = new PDO($dsnV4, $user, $password);

/*************************
*** INSERTION DES GROUPS *
**************************/
$dbv4->query('INSERT INTO groups VALUES (1, "SuperAdmin", NOW(), NOW()), (2, "Forums", NOW(), NOW())');

/************
*** USERS  **
************/
$sql = 'SELECT id, username, email, created_at, updated_at, nb_messages FROM users';
$i = 0;
foreach ($dbv3->query($sql) as $row) {
    $i++;
    $sth = $dbv4->prepare(
        'INSERT INTO `laravelfr4`.`users`
            (`id`, `username`, `email`, `created_at`, `updated_at`, `nb_messages`)
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            );'
    );
    $sth->execute(array(
        $row['id'],
        $row['username'],
        $row['email'],
        $row['created_at'],
        $row['updated_at'],
        $row['nb_messages'],
    ));
}
echo '- '.$i.' users OK'. NL;

/***********
** oauth **
***********/
$sql = 'SELECT id, user_id, provider, uid, access_token, secret, created_at, updated_at FROM oneauth_clients;';
$i = 0;
foreach ($dbv3->query($sql) as $row) {
    $i++;
    $sth = $dbv4->prepare(
        'INSERT INTO `laravelfr4`.`oauth`
            (`id`, `user_id`, `provider`, `uid`, `access_token`, `secret`, `created_at`, `updated_at`)
            VALUES
            (
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?,
                ?
            );'
    );

    $sth->execute(array(
        $row['id'],
        $row['user_id'],
        $row['provider'],
        $row['uid'],
        $row['access_token'],
        $row['secret'],
        $row['created_at'],
        $row['updated_at'],
    ));
}
$dbv4->query('UPDATE `laravelfr4`.`oauth` SET `provider` = "Google" WHERE `provider` = "google";');
$dbv4->query('UPDATE `laravelfr4`.`oauth` SET `provider` = "Twitter" WHERE `provider` = "twitter";');
$dbv4->query('UPDATE `laravelfr4`.`oauth` SET `provider` = "GitHub" WHERE `provider` = "github";');


echo '- '.$i.' oauth OK'. NL;


/***************
** FORUMS CAT **
****************/
$sql = 'SELECT `id`, `order`, `title`, `slug`, `desc`, `created_at`, `updated_at` FROM forumcategories;';
$i = 0;
foreach ($dbv3->query($sql) as $row) {
    $i++;
    $sth = $dbv4->prepare(
        'INSERT INTO `laravelfr4`.`forum_categories`
            (`id`, `order`, `title`, `slug`, `desc`, `created_at`, `updated_at`)
            VALUES
            (
                ?, ?, ?, ?, ?, ?, ?
            );'
    );
    $sth->execute(array(
        $row['id'],
        $row['order'],
        $row['title'],
        $row['slug'],
        $row['desc'],
        $row['created_at'],
        $row['updated_at'],
    ));
}

echo '- '.$i.' forums categories OK'. NL;
flush();

/*******************
** FORUMS TOPICS ***
*******************/
$sql = 'SELECT id, forumcategory_id as forum_category_id, user_id, sticky, title, slug, nb_views, created_at, updated_at FROM forumtopics;';
$i = 0;
foreach ($dbv3->query($sql) as $row) {
    $i++;
    $sth = $dbv4->prepare(
        'INSERT INTO `laravelfr4`.`forum_topics`
            (id, forum_category_id, user_id, sticky, title, slug, nb_views, created_at, updated_at)
            VALUES
            (
               ?, ?, ?, ?, ?, ?, ?, ?, ?
            );'
    );
    $sth->execute(array(
        $row['id'],
        $row['forum_category_id'],
        $row['user_id'],
        $row['sticky'],
        $row['title'],
        $row['slug'],
        $row['nb_views'],
        $row['created_at'],
        $row['updated_at'],
    ));
}

echo '- '.$i.' forums topics OK'. NL;
flush();

/*********************
** FORUMS MESSAGES ***
*********************/
$sql = 'SELECT id, content as html, content_bbcode as bbcode, user_id, forumtopic_id as forum_topic_id, forumcategory_id as forum_category_id, created_at, updated_at FROM forummessages;';
$i = 0;
foreach ($dbv3->query($sql) as $row) {
    $i++;
    $sth = $dbv4->prepare(
        'INSERT INTO `laravelfr4`.`forum_messages`
            (id, html, bbcode, user_id, forum_topic_id, forum_category_id, created_at, updated_at)
            VALUES
            (
               ?, ?, ?, ?, ?, ?, ?, ?
            );'
    );
    $sth->execute(array(
        $row['id'],
        $row['html'],
        $row['bbcode'],
        $row['user_id'],
        $row['forum_topic_id'],
        $row['forum_category_id'],
        $row['created_at'],
        $row['updated_at'],
    ));
}

echo '- '.$i.' forums messages OK'. NL;
flush();


echo "". NL;
echo "******************************************". NL;
echo "***".FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE."***". NL;
echo "***".FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE."CONSOLIDATION".FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE."***". NL;
echo "***".FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE.FORCE_SPACE."***". NL;
echo "******************************************". NL;
echo "". NL;

echo 'Groupe ADMIN pour le user 1...';
$dbv4->query('INSERT INTO `group_user` (`id`, `group_id`, `user_id`, `created_at`, `updated_at`) VALUES (1, 1, 1, NOW(), NOW());');
echo 'OK'. NL;
flush();

echo 'nombre de posts par users...';
$dbv4->query('UPDATE users as u SET nb_messages = (SELECT COUNT(*) from forum_messages as fm WHERE fm.user_id = u.id) where u.id > 0;');
echo 'OK'. NL;
flush();

echo 'Definition du nombre de topics et de messages par categories...';
$dbv4->query(
    'UPDATE forum_categories as fc SET
        nb_topics = (SELECT COUNT(*) from forum_topics as ft WHERE ft.forum_category_id = fc.id),
        nb_posts = (SELECT COUNT(*) from forum_messages as fm WHERE fm.forum_category_id = fc.id)
        '
);
echo 'OK'. NL;
flush();

echo 'Definition du nombre de messages par topics...';
$dbv4->query(
    'UPDATE forum_topics as ft SET
        nb_messages = (SELECT COUNT(*) from forum_messages as fm WHERE fm.forum_topic_id = ft.id)
        '
);
echo 'OK'. NL;
flush();


echo 'Definition du dernier message par categories...';
$dbv4->query(
    'UPDATE forum_categories as fc SET
    lm_user_name = (SELECT u.username as lm_user_name from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_user_id = (SELECT u.id as lm_user_id from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_topic_name = (SELECT ft.title as lm_topic_name from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_topic_slug = (SELECT ft.slug as lm_topic_slug from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_topic_id = (SELECT ft.id as lm_topic_id from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_post_id = (SELECT fm.id as lm_post_id from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_date = (SELECT fm.created_at as lm_date from forum_messages as fm JOIN forum_topics as ft ON ft.id = fm.forum_topic_id JOIN users as u ON u.id = fm.user_id WHERE fm.forum_category_id = fc.id ORDER BY fm.created_at DESC LIMIT 1)
'
);
echo 'OK'. NL;
flush();

echo 'Definition du dernier message par topics...';
$dbv4->query(
    'UPDATE forum_topics as ft SET
    lm_user_name = (SELECT u.username as lm_user_name from forum_messages as fm JOIN users as u ON u.id = fm.user_id WHERE fm.forum_topic_id = ft.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_user_id = (SELECT u.id as lm_user_id from forum_messages as fm JOIN users as u ON u.id = fm.user_id WHERE fm.forum_topic_id = ft.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_post_id = (SELECT fm.id as lm_post_id from forum_messages as fm JOIN users as u ON u.id = fm.user_id WHERE fm.forum_topic_id = ft.id ORDER BY fm.created_at DESC LIMIT 1),
    lm_date = (SELECT fm.created_at as lm_date from forum_messages as fm JOIN users as u ON u.id = fm.user_id WHERE fm.forum_topic_id = ft.id ORDER BY fm.created_at DESC LIMIT 1)
'
);
echo 'OK'. NL;
flush();


if (php_sapi_name() !== 'cli') {
    echo "</pre>";
}
