<?php

namespace PostiWarehouse\Classes;

defined('ABSPATH') || exit;

class Logger {

    const db_version = '1.0';
    const table_name = 'posti_warehouse_logs';
    private $is_debug = false;

    public static function install() {
        global $wpdb;

        $table_name = $wpdb->prefix . self::table_name;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		type tinytext NOT NULL,
		message text NOT NULL,
		created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta($sql);

        add_option('posti_warehouse_db_version', self::db_version);
    }

    public static function uninstall() {
        global $wpdb;
        $table_name = $wpdb->prefix . self::table_name;
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
        delete_option("posti_warehouse_db_version");
    }
    
    public function setDebug($value){
        $this->is_debug = $value;
    }

    public function log($type, $message) {
        if ($this->is_debug){
            global $wpdb;

            $table_name = $wpdb->prefix . self::table_name;

            $wpdb->insert(
                    $table_name,
                    array(
                        'type' => $type,
                        'message' => $message,
                        'created_at' => date('Y-m-d H:i:s'),
                    )
            );
        }
    }

    public function getLogs() {
        global $wpdb;
         
        $this->clearOldLogs();
       
        $table_name = $wpdb->prefix . self::table_name;

        $results = $wpdb->get_results("SELECT * FROM " . $table_name . " order by created_at DESC, id DESC LIMIT 50");
        return $results;
    }

    private function clearOldLogs() {
        global $wpdb;

        $table_name = $wpdb->prefix . self::table_name;

        $sql = 'DELETE FROM `' . $table_name . '` WHERE `created_at` < %s;';

        try {
            $wpdb->query($wpdb->prepare($sql, array(date('Y-m-d H:i:s', time()-3600*24*3))));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
