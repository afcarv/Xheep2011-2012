import java.util.Date;

/**
 * Class representing a SystemTicket (senha de sistema).
 */
class SystemTicket extends Ticket
{
	/**
	 * Station to which the ticket was required for
	 */
	public Station station;
	/**
	 * Description of the issue
	 */
	public String description;
	
	
	public SystemTicket()
	{
		super();
		this.type = "system";
		this.station = null;
		this.description = "";
	}
	
	SystemTicket(Person author, Date date,
			Station station, String description)
	{
		// calls parent constructor
		super( author, date);
		
		this.station = station;
		this.description = description;
	}

	public String toString()
	{
		return super.toString() +
		"| station: " + this.station.id +
		"| topic: " + this.description;
	}
}