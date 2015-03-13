<?php
/**
 * Created by PhpStorm.
 * User: aosiname
 * Date: 09/03/2015
 * Time: 16:25
 */
/*not used. nice idea though...*/
class FANComment {
    protected $text;
    protected $dateWritten;

    // should be a global $USER Moodle object but for now, the id will suffice.
    // will have to specify/filter the constructor argument input type when you do this...
    protected $person;

    public function __construct($p) {
        $this->person = $p;
    }


    /**
     * @return mixed
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getDateWritten()
    {
        return $this->dateWritten;
    }

    /**
     * @param mixed $dateWritten
     */
    public function setDateWritten($dateWritten)
    {
        $this->dateWritten = $dateWritten;
    }

    /**
     * @return mixed
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param mixed $person
     */
    public function setPerson($person)
    {
        $this->person = $person;
    }
}