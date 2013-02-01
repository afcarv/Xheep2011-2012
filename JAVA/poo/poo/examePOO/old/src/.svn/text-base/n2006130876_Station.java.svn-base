import java.io.Serializable;

/**
 * Class Representing a Station.
 */
class Station implements Serializable
{
	/**
	 * Required for serialization
	 */
	private static final long serialVersionUID = 220727677960360309L;
	
	/**
	 * Station ID
	 */
	public int id;
	/**
	 * Station's Name (must be unique)
	 */
	public String name;
	/**
	 * Operating System
	 */
	public String os;
	/**
	 * CPU
	 */
	public String cpu;
	/**
	 * Hard Drive
	 */
	public float hdd;
	/**
	 * RAM
	 */
	public float ram;

	/**
	*	Contructor
	*/
	Station()
	{
		this.id = 0;
		this.name = "";
		this.os = "";
		this.cpu = "";
		this.hdd = 0;
		this.ram = 0;
	}
	
	Station(String name, String os ,String cpu, int hdd, int ram)
	{
		this();
		
		this.name = name;
		this.os = os;
		this.cpu = cpu;
		this.hdd = hdd;
		this.ram = ram;
	}
	
	/**
	 * toString Overide
	 */
	public String toString()
	{
		return "id: " + this.id +
			"| name: " + this.name +
			"| os: " + this.os +
			"| cpu: " + this.cpu +
			"| hdd: " + this.hdd +
			"| ram: " + this.ram;
	}
}
