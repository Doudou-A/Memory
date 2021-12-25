<?php

namespace Model;

class Game
{
	private $_id;
	private $_gameTime;

	public function __construct(array $data)
    {
        $this->hydrate($data);
    }
 
    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
 
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

	//Getters

	public function id() { return $this->_id; }
	public function gameTime()	{ return $this->_gameTime;	}

	//Setters

	public function setId($id)
	{
		$id = (int) $id;

		if ($id >0)
		{
			$this->_id = $id;
		}
	}

	public function setGameTime($gameTime)
	{
		if (is_string($gameTime))
		{
			$this->_gameTime = $gameTime;
		}
	}
}