import java.util.Date;

/**
 * Class representing an Intervention
 */
class Intervention
{
	public Date date;
	public int duration;
	public String description;
	public Person technician;
	public boolean resolved;
	
	/**
	*	Contructor
	*/
	Intervention()
	{
		/**
		 * Intervention date
		 */
		this.date = null;
		/**
		 * Intervention duration in minutes
		 */
		this.duration = 0;
		/**
		 * Intervention description
		 */
		this.description = "";
		/**
		 * Technician that did the intervention
		 */
		this.technician = null;
		/**
		 * Did the intervention resolved the ticket
		 */
		this.resolved = false;
	}
	
	Intervention(int id, Date date, int duration, String description, Person technician, boolean resolved)
	{
		this();
		
		this.date = date;
		this.duration = duration;
		this.description = description;
		this.technician = technician;
		this.resolved = resolved;
	}
	
	/**
	 * toString Overide
	 */
	public String toString()
	{
		return "date: " + this.date +
			"| duration: " + this.duration +
			"| description: " + this.description +
			"| technician: " + this.technician.id +
			"| resolved: " + this.resolved;
	}
}
