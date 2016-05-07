<?php

/**
 * Created by PhpStorm.
 * User: songhao
 * Date: 16/5/8
 * Time: 上午12:02
 */
class category extends db
{
    function __construct()
    {
        parent::__construct();
    }
    /*
     * 拉取所有栏目
     */
    function cat_list()
    {
        $top_cat = $this->mysql->query('SELECT * FROM `category` WHERE `position` = 0 AND `status` = 0 ORDER BY `order` ASC;');
        $return_vars = array();
        while($cats = mysqli_fetch_array($top_cat))
        {
            $return_vars['root'][] = $cats;
            //get child
            $child_cat = $this->get_child_cats($cats['id']);
            if($child_cat) {
                $return_vars['child'][$cats['id']] = $child_cat;
            }
        }
        return $return_vars;
    }
    /*
     * 获得$cat_id
     */
    function get_child_cats($cat_id)
    {
        if(is_numeric($cat_id)) {
            $current_cat = $this->mysql->query("SELECT * FROM `category` WHERE `position` = {$cat_id}  AND `status` = 0 ORDER BY `order` ASC;");
            if(mysqli_num_rows($current_cat))
            {
                $return_vars = array();
                while($cats = mysqli_fetch_array($current_cat))
                {
                    $return_vars[] = $cats;
                    //get child
                    $child_cat = $this->get_child_cats($cats['id']);
                    if($child_cat) {
                        $return_vars['child'][$cats['id']] = $child_cat;
                    }
                }
                return $return_vars;
            }
            else{
                return NULL;
            }
        }
    }
}