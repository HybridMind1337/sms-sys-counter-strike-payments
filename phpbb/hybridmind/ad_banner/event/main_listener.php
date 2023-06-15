<?php
namespace hybridmind\ad_banner\event;

use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{

    protected config $config;
    protected template $template;
    protected user $user;
    protected driver_interface $database;
    protected language $language;

    /**
     * main_listener constructor.
     * @param $config
     * @param $template
     * @param $user
     * @param $database
     * @param $language
     */
    public function __construct($config, $template, $user, $database, $language)
    {
        $this->config = $config;
        $this->template = $template;
        $this->user = $user;
        $this->database = $database;
        $this->language = $language;
    }


    /**
     * @return string[]
     */
    public static function getSubscribedEvents(): array
    {
        return [
            'core.user_setup' => 'load_language_on_setup',
            'core.page_footer' => 'ad_banner'
        ];
    }

    /**
     * @param $event
     */
    public function load_language_on_setup($event)
    {
        $lang_set_ext = $event['lang_set_ext'];
        $lang_set_ext[] = [
            'ext_name' => 'hybridmind/ad_banner',
            'lang_set' => 'common',
        ];
        $event['lang_set_ext'] = $lang_set_ext;
    }

    /**
     * @param $event
     */
    public function ad_banner($event)
    {
        $sql_query = $this->database->sql_query("SELECT * FROM banners ORDER BY RAND() LIMIT 1");
        while ($row = $this->database->sql_fetchrow($sql_query)) {
            $this->template->assign_block_vars('adsl', [
                "id" => $row['id'],
                "url" => $row['url'],
                "image" => $row['image'],
                "name" => $row['name']
            ]);
        }
        $this->database->sql_freeresult($sql_query);

        $sql_query = $this->database->sql_query("SELECT * FROM banners ORDER BY RAND() LIMIT 1");
        while ($row = $this->database->sql_fetchrow($sql_query)) {
            $this->template->assign_block_vars('adsr', [
                "id" => $row['id'],
                "url" => $row['url'],
                "image" => $row['image'],
                "name" => $row['name']
            ]);
        }
        $this->database->sql_freeresult($sql_query);

    }
}
