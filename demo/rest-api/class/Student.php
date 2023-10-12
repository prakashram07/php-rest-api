<?php
class Students
{

	private $student_table = "student";
	public $id;
	public $name;
	public $email;
	public $contact;
	public $address;
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	function read()
	{
		if ($this->id) {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->student_table . " WHERE id = ?");
			$stmt->bind_param("i", $this->id);
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->student_table);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function create()
	{

		$stmt = $this->conn->prepare("
			INSERT INTO " . $this->student_table . "(`name`, `email`, `contact`, `address`)
			VALUES(?,?,?,?)");

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->contact = htmlspecialchars(strip_tags($this->contact));
		$this->address = htmlspecialchars(strip_tags($this->address));


		$stmt->bind_param("ssiis", $this->name, $this->email, $this->contact, $this->address);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function update()
	{

		$stmt = $this->conn->prepare("
			UPDATE " . $this->student_table . " 
			SET name= ?, email = ?, contact = ?, address = ?
			WHERE id = ?");

		$this->id = htmlspecialchars(strip_tags($this->id));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->contact = htmlspecialchars(strip_tags($this->contact));
		$this->address = htmlspecialchars(strip_tags($this->address));

		$stmt->bind_param("ssiisi", $this->name, $this->email, $this->contact, $this->address, $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}

	function delete()
	{

		$stmt = $this->conn->prepare("
			DELETE FROM " . $this->student_table . " 
			WHERE id = ?");

		$this->id = htmlspecialchars(strip_tags($this->id));

		$stmt->bind_param("i", $this->id);

		if ($stmt->execute()) {
			return true;
		}

		return false;
	}
}
