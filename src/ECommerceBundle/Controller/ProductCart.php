<?php
namespace ECommerceBundle\Controller;


class ProductCart {
    private $id;
    private $nombre;
    private $precio;
    private $foto;
    private $fotoHover;
    private $count;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $precio
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;
    }

    /**
     * @return mixed
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * @param mixed $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param mixed $foto
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }

    /**
     * @return mixed
     */
    public function getFoto()
    {
        return $this->foto;
    }
    
    /**
     * @param mixed $foto
     */
    public function setFotoHover($fotoHover)
    {
        $this->fotoHover = $fotoHover;
    }

    /**
     * @return mixed
     */
    public function getFotoHover()
    {
        return $this->fotoHover;
    }

    public function getAmmount() {
        return $this->precio * $this->count;
        //return number_format(, 2);
    }
}