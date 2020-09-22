<?php

namespace app\api\examples;

use App\Domain\Examples\CURD as DomainCURD;

/**
 * 数据库CURD基本操作示例
 * @author dogstar 20170612
 */
class CURD extends \core\Api {

    public function getRules() {
        return array(
            'insert' => array(
                'title' => '插入数据',
                'method' => 'post',
                'url' => '/insert',
                'desc' => '向数据库插入一条纪录数据',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'title' => array('name' => 'title', 'require' => true, 'min' => 1, 'max' => '20', 'desc' => '标题'),
                    'content' => array('name' => 'content', 'require' => true, 'min' => 1, 'desc' => '内容'),
                    'state' => array('name' => 'state', 'type' => 'int', 'default' => 0, 'desc' => '状态'),
                ),
                'return' => array(
                    'id' => array('name' => 'id', 'type' => 'int', 'desc' => '新增的ID'),
                ),
            ),
            'update' => array(
                'title' => '更新数据',
                'method' => 'post',
                'url' => '/update',
                'desc' => '根据ID更新数据库中的一条纪录数据',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
                    'title' => array('name' => 'title', 'require' => true, 'min' => 1, 'max' => '20', 'desc' => '标题'),
                    'content' => array('name' => 'content', 'require' => true, 'min' => 1, 'desc' => '内容'),
                    'state' => array('name' => 'state', 'type' => 'int', 'default' => 0, 'desc' => '状态'),
                ),
                'return' => array(
                    'code' => array('name' => 'code', 'type' => 'int', 'desc' => '更新的结果，1表示成功，0表示无更新，false表示失败'),
                ),
            ),
            'get' => array(
                'title' => '获取数据',
                'url' => '/get',
                'desc' => '根据ID获取数据库中的一条纪录数据',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
                ),
                'return' => array(
                    'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
                    'title' => array('name' => 'title', 'type' => 'string', 'desc' => '标题'),
                    'content' => array('name' => 'content', 'type' => 'string', 'desc' => '内容'),
                ),
            ),
            'delete' => array(
                'title' => '删除数据',
                'method' => 'post',
                'url' => '/delete',
                'desc' => '根据ID删除数据库中的一条纪录数据',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'id' => array('name' => 'id', 'require' => true, 'min' => 1, 'desc' => 'ID'),
                ),
                'return' => array(
                    'code' => array('name' => 'code', 'type' => 'int', 'desc' => '删除的结果，1表示成功，0表示失败'),
                ),
            ),
            'getList' => array(
                'url' => '/getList',
                'title' => '获取分页列表数据',
                'method' => 'get',
                'desc' => '根据状态筛选列表数据，支持分页',
                //'exceptions' => array('401'=> '异常了'),
                'input' => array(
                    'page' => array('name' => 'page', 'type' => 'int', 'min' => 1, 'default' => 1, 'desc' => '第几页'),
                    'perpage' => array('name' => 'perpage', 'type' => 'int', 'min' => 1, 'max' => 20, 'default' => 10, 'desc' => '分页数量'),
                    'state' => array('name' => 'state', 'type' => 'int', 'default' => 0, 'desc' => '状态'),
                ),
                'return' => array(
                    'items' => array('name' => 'items', 'type' => 'arrayList', 'desc' => '列表数据'),
                    'total' => array('name' => 'total', 'type' => 'int', 'desc' => '总数量'),
                    'page' => array('name' => 'page', 'type' => 'int', 'desc' => '当前第几页'),
                    'perpage' => array('name' => 'page', 'type' => 'int', 'desc' => '每页数量'),
                ),
            ),
        );
    }

}
