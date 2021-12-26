<?php

namespace Model;

class User
{
    // Déclaration des attributs
	private $_id;
    private $_name;
    private $_idGame;

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
    public function name()	{ return $this->_name;	}
    public function idGame()	{ return $this->_idGame;	}

	//Setters
	public function setId($id)
	{
		$id = (int) $id;

		if ($id >0)
		{
			$this->_id = $id;
		}
	}

	public function setName($name)
	{
		if (is_string($name))
		{
			$this->_name = $name;
		}
	}

	public function setIdGame($idGame)
    {
        if (is_string($idGame))
        {
            $this->_idGame = $idGame;
        }
    }

}