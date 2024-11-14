<?php

class Cola
{
    private $cola = [];

    public function encolar($item)
    {
        array_push($this->cola, $item);
    }

    public function desencolar()
    {
        if ($this->esVacia()) {
            return null;
        }
        return array_shift($this->cola);
    }

    public function esVacia()
    {
        return empty($this->cola);
    }

    public function buscarPorAtributo($clave, $valor)
    {
        foreach ($this->cola as $equipo) {
            if (array_key_exists($clave, $equipo) && stripos($equipo[$clave], $valor) !== false) {
                return $equipo;
            }
        }
        return null;
    }

    public function obtenerTodos()
    {
        return $this->cola;
    }
}
