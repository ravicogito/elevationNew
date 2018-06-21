<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment{

	public function __construct()
	{
		$this->first_name	= null;
		$this->last_name	= null;
		$this->address		= null;
		$this->email		= null;
		$this->phone		= null;
		$this->country		= null;
		$this->city			= null;
		$this->state		= null;
		$this->pincode		= null;
		$this->card			= null;
		$this->month		= null;
		$this->year			= null;
		$this->cvv			= null;
		

	}

	private $first_name;
	private $last_name;
	private $address;
	private $email;
	private $phone;
	private $country;
	private $city;
	private $state;
	private $pincode;
	private $card;
	private $month;
	private $year;
	private $cvv;
	private $amt;

	public function set_fname($name)
	{
		$this->first_name = $name;
	}

	public function get_fname()
	{
		return $this->first_name;
	}


	public function set_lname($name)
	{
		$this->last_name = $name;
	}
	
	public function get_lname()
	{
		return $this->last_name;
	}


	public function set_email($email)
	{
		$this->email = $email;
	}
	
	public function get_email()
	{
		return $this->email;
	}


	public function set_phone($ph)
	{
		$this->phone = $ph;
	}
	
	public function get_phone()
	{
		return $this->first_name;
	}

	public function set_country($country)
	{
		$this->country = $country;
	}

	public function get_address()
	{
		return $this->address;
	}

	public function set_address($address)
	{
		$this->address = $address;
	}
	
	public function get_country()
	{
		return $this->country;
	}

	public function set_state($state)
	{
		$this->state = $state;
	}
	
	public function get_state()
	{
		return $this->state;
	}


	public function set_city($city)
	{
		$this->city = $city;
	}
	
	public function get_city()
	{
		return $this->city;
	}

	public function set_pincode($pincode)
	{
		$this->pincode = $pincode;
	}
	
	public function get_pincode()
	{
		return $this->pincode;
	}

	public function set_card($card)
	{
		$this->card = $card;
	}
	
	public function get_card()
	{
		return $this->card;
	}

	public function set_month($month)
	{
		$this->month = $month;
	}
	
	public function get_month()
	{
		return $this->month;
	}
	

	public function set_year($year)
	{
		$this->year = $year;
	}
	
	public function get_year()
	{
		return $this->year;
	}

	public function set_cvv($cvv)
	{
		$this->cvv = $cvv;
	}
	
	public function get_cvv()
	{
		return $this->cvv;
	}

	public function set_amt($amt)
	{
		$this->amt = $amt;
	}
	
	public function get_amt()
	{
		return $this->amt;
	}	
}

/* End of file Payment.php */
/* Location: ./application/controllers/Payment.php */