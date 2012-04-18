<?php

/**
 *
 *
 * @package decorator
 * @subpackage site_decorator
 *
 * @author ebollens
 * @copyright Copyright (c) 2010-11 UC Regents
 * @license http://mwf.ucla.edu/license
 * @version 20110518
 *
 * @uses Decorator
 * @uses Tag_HTML_Decorator
 * @uses Config
 */
require_once(dirname(dirname(dirname(__FILE__))) . '/decorator.class.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/config.class.php');
require_once(dirname(dirname(__FILE__)) . '/html/tag.class.php');

class Footer_Site_Decorator extends Tag_HTML_Decorator {

    private $_copyright = false;
    private $_help_title = false;
    private $_help_url = '#';
    private $_full_title = 'Full Site';
    private $_full_url = 'http://www.berkeley.edu/?ovrrdr=1';
    private $_powered_by = false;
	private $_search_url = '/search';
	private $_search_title = 'Search';
	private $_atoz_url = '/atoz';
	private $_atoz_title = 'A-Z';
	private $_about_url = '/about';
	private $_about_title = 'About';
	private $_contact_url = '/contact';
	private $_contact_title = 'Contact';

    public function __construct() {
        parent::__construct('div');

        if ($copyright = Config::get('global', 'copyright_text'))
            $this->set_copyright_text($copyright);
    }

    public function &set_copyright_text($text) {
        $this->_copyright = $text;
        return $this;
    }

    public function &set_help_site($title, $url = '#') {
        $this->_help_title = $title;
        $this->_help_url = $url;
        return $this;
    }

    public function &set_full_site($title, $url = '#') {
        $this->_full_title = $title;
        $this->_full_url = $url;
        return $this;
    }
	
	public function &set_search($title, $url = '#')
    {
        $this->_search_title = $title;
        $this->_search_url = $url;
        return $this;
    }
	
	public function &set_about($title, $url = '#')
    {
        $this->_about_title = $title;
        $this->_about_url = $url;
        return $this;
    }
	
	public function &set_atoz($title, $url = '#')
    {
        $this->_atoz_title = $title;
        $this->_atoz_url = $url;
        return $this;
    }
	
	public function &set_contact($title, $url = '#')
    {
        $this->_contact_title = $title;
        $this->_contact_url = $url;
        return $this;
    }

    public function &show_powered_by($val = true) {
        $this->_powered_by = $val ? true : false;
        return $this;
    }

    public function render() {
        $this->set_param('id', 'footer');

        if ($this->_copyright || $this->_full_title || $this->_help_title) {
            $p = HTML_Decorator::tag('p');
<<<<<<< HEAD

            //if($this->_copyright)
            //    $p->add_inner($this->_copyright);
           // if($this->_copyright && ($this->_full_title || $this->_help_title))
           //    $p->add_inner('<br/>');

            if($this->_full_title)
                $p->add_inner_tag('a', $this->_full_title, array('href'=>$this->_full_url));
            if($this->_full_title && $this->_atoz_title || $this->_search_title)
                $p->add_inner('<span class="footer-item-divider"></span>');
			if($this->_search_title)
                $p->add_inner_tag('a', $this->_search_title, array('href'=>$this->_search_url));
				else
				$p->add_inner('<span class="footer-item-divider"></span>Search<span class="footer-item-divider"></span>');
			if($this->_search_title && $this->_atoz_title)
                $p->add_inner('<span class="footer-item-divider"></span>');
            if($this->_atoz_title)
                $p->add_inner_tag('a', $this->_atoz_title, array('href'=>$this->_atoz_url));
				else
				$p->add_inner('<span class="footer-item-divider"></span>A-Z<span class="footer-item-divider"></span>');
            if($this->_atoz_title && $this->_about_title)
                $p->add_inner('<span class="footer-item-divider"></span>');
            if($this->_about_title)
                $p->add_inner_tag('a', $this->_about_title, array('href'=>$this->_about_url));
				else
				$p->add_inner('<span class="footer-item-divider"></span>About<span class="footer-item-divider"></span>');
            if($this->_about_title && $this->_contact_title)
                $p->add_inner('<span class="footer-item-divider"></span>');				
            if($this->_contact_title)
                $p->add_inner_tag('a', $this->_contact_title, array('href'=>$this->_contact_url));
				else
				$p->add_inner('<span class="footer-item-divider"></span>Contact');
			$this->add_inner($p);	           
        }

		if($this->_powered_by && $this->_copyright)
        {
            $this->add_inner_tag('p', $this->_copyright . '<br />' .'<em>Powered by the <a href="http://mwf.ucla.edu" target="_blank">UCLA Mobile Web Framework</a></em>');
        }
		elseif ($this->_copyright)
			 $this->add_inner_tag('p', $this->_copyright);
        return parent::render();
    }

}
