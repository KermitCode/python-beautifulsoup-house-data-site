<?php

namespace lib;
use lib\Dao;

class Model
{
    
    //关联的表及主键标识
    public $primaryKey = 'id';
    public $table='';
    
    //默认使用读库连接:对应配置文件中的default配置
    private static $_defaultDb = 'default';
    
    //当前连接资源
    protected static $source = null;
    
    //模型属性
	public $Attributes=array();
    
    //模型取数据时的条件
	private $Conditions=array();

    //模型实例化查询时必须指定表
	private function __checkTable()
    {
		if(!$this->table)
		{
            exit("no table assign in ModelClass:".get_called_class());
		}
	}
    
    //实例化模型
    public function __construct($db = null)
    {
        $this->__checkTable();
        
        //默认连接读库
        !$db && $db = self::$_defaultDb;
        
        self::$source = Dao::__getInstance($db);
        
        $this->primary && $this->primaryKey = $this->primary;
    }

    //直接读取DB进行查询
    public static function DB($db = null)
    {
        $db === null && $db = self::$_defaultDb;
        
        return Dao::__getInstance($db);
    }

    //取相关数据
    public function __get($key)
    {
        //一些常用的属性可在此扩展写
        switch($key)
        {
            case 'db'           :return self::$source;
            /*case 'dbVersion'	:return self::$source->showVersion();
            case 'lastInsertId' :return self::$source->getLastInsertId();
            case 'affectedRows' :return self::$source->getAffectedRows();
            case 'lastSql'		:return self::$source->getLastSql();
            case 'sqlTimes'		:return self::$source->getSqlTimes();*/
            
            default				:return null;
        }

    }

	//直接执行原始查询SQL
	public function query($sql)
	{
		return self::$source->querySql($sql);
	}

	//直接执行原始增改SQL
	public function exec($sql)
	{
		return self::$source->executeSql($sql);
	}
    
    //通过ID取一条记录:
    public function getOneById($id, $field='*')
    {
        $this->__checkTable();
        
        $data = self::$source->select($this->table, array($this->primaryKey => $id), array('field'=>$field) );
        
        return $data[0];  
    }

	//获取一行数据
	public function getOne($conditions, $fields='*')
	{
        $this->__checkTable();
        
        $data = self::$source->select($this->table, $conditions, array('field'=>$field) );

		return $data[0];

	}

	//获取多行数据
	public function select($conditions=array(), $extend=array())
	{

		$this->__checkTable();
        
        return self::$source->select($this->table, $conditions, $extend );

	}

	//更新模型数据
	public function update($data, $conditions= array())
	{

		$this->__checkTable();
        
        return self::$source->update($this->table, $data, $conditions );
        
	}
    
    //通过ID更新一条记录:
    public function updateById($id, $data)
	{

		$this->__checkTable();
        
        return self::$source->update($this->table, $data, array($this->primaryKey => $id) );
        
	}

	//删除模型数据
	public function delete($conditions)
	{

		$this->__checkTable();
        
        return self::$source->delete($this->table, $conditions);

	}
    
    //删除模型数据
	public function deleteById($id)
	{

		$this->__checkTable();
        
        return self::$source->delete($this->table, array($this->primaryKey => $id) );

	}

	//模型插入数据
	public function insert($data)
	{

		$this->__checkTable();

		return self::$source->insert($this->table, $data );

	}

	//数据自增
	public function increment($field, $conditions, $add=1)
	{

		$this->__checkTable();

		return self::$source->increment($this->table, $field, $conditions, $add);

	}

	//查询数量
	public function count($conditions=array(), $field='')
	{

		$this->__checkTable();

		return self::$source->count($this->table, $conditions, $field);

	}

    //表字段求和
	public function sum($field, $conditions=array())
	{

        $this->__checkTable();

		return self::$source->sum($this->table, $field, $conditions);

	}
    
    //读出SQL日志
    public function getQueryed($db=null)
    {
        return self::$source->getQueryed($db);
    }
	
}