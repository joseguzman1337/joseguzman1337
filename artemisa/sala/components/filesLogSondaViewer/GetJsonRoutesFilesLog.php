<?php

class GetJsonRoutesFilesLog
{
    #conexion bd
    private $db;
    #route de folder donde se almacenan los log
    private $routeFiles;
    #array de archivos
    private $filesArray;


    public function __construct($dbConection)
    {
        $this->routeFiles = realpath(dirname(__FILE__) . "/../../../libsoap/logsSondaEcollet");
        $this->db = $dbConection;
        $this->getListFiles();
    }

    public function getListFiles()
    {
        try
        {
            $dirFiles = scandir($this->routeFiles,1);

        }catch (\Exception $e)
        {
            $dirFiles = array();
        }
        $this->filesArray = $dirFiles;

    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
    }

    /**
     * @return false|string
     */
    public function getRouteFiles()
    {
        return $this->routeFiles;
    }

    /**
     * @param false|string $routeFiles
     */
    public function setRouteFiles($routeFiles)
    {
        $this->routeFiles = $routeFiles;
    }

    /**
     * @return mixed
     */
    public function getFilesArray()
    {
        return $this->filesArray;
    }

    /**
     * @param mixed $filesArray
     */
    public function setFilesArray($filesArray)
    {
        $this->filesArray = $filesArray;
    }


}