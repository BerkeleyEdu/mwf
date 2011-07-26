<?php
class Locations implements Iterator
{
    private $_url;
    private $_pos = 0;
    private $_loc = null;
    private $_idx = null;

    public function __construct($url)
    {
        $this->_url = $url;
    }

    public function get($pos)
    {
        if(!is_array($this->_loc))
            $this->load();

        return isset($this->_loc[$pos]) ? $this->_loc[$pos] : false;
    }

    public function get_all()
    {
        if(!is_array($this->_loc))
            $this->load();

        return $this->_loc;
    }

    public function find($name)
    {
        if(!is_array($this->_loc))
            $this->load();
        
        return isset($this->_idx[md5($name)]) ? $this->_loc[$this->_idx[md5($name)]] : false;
    }

    public function search($partial)
    {
        $locations = array();

        foreach($this as $location)
            if(stripos($location['name'], $partial) !== false)
                $locations[] = $location;

        return $locations;
    }

    public function load()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        if(!($result = curl_exec($ch)))
            trigger_error(curl_error($ch));
        curl_close($ch);

        $this->_loc = array();
        $this->_idx = array();

        $i = 0;
        $root = new SimpleXMLElement($result);
        foreach($root->Location as $location)
        {
            $this->_idx[md5($location->Name)] = $i;
            $this->_loc[$i++] = array('name'=>$location->Name,
                                      'lat'=>$location->Lat,
                                      'lon'=>$location->Lon);
        }
    }

    public function current()
    {
        return $this->get($this->_pos);
    }

    public function key()
    {
        return $this->_pos;
    }

    public function next()
    {
        $this->_pos++;
    }

    public function rewind()
    {
        $this->_pos = 0;
    }

    public function valid()
    {
        if(!is_array($this->_loc))
            $this->load();
        
        return isset($this->_loc[$this->_pos]);
    }
}

?>
