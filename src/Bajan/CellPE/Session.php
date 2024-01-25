<?php

namespace Bajan\CellPE;

class Session {

    /** @var CellPE */
    private $plugin;
    private $name = [];
    private $price = [];
    /** @var array */
    private $session = [];

    public function __construct(CellPE $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param $p
     * @return string|null
     */
    public function searchName($p) {
        return $this->name[$p] ?? null;
    }

    /**
     * @param $p
     * @param $name
     */
    public function setName($p, $name) {
        $this->name[$p] = $name;
    }

    /**
     * @param $p
     * @return mixed|null
     */
    public function searchPrice($p) {
        return $this->price[$p] ?? null;
    }

    /**
     * @param $p
     * @param $price
     */
    public function setPrice($p, $price) {
        $this->price[$p] = $price;
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function getSession($name) {
        return $this->session[$name] ?? null;
    }

    /**
     * @param $name
     * @param $session
     */
    public function setSession($name, $session) {
        $this->session[$name] = $session;
    }

    /**
     * @param $name
     */
    public function removeSession($name) {
        unset($this->session[$name]);
    }
}
