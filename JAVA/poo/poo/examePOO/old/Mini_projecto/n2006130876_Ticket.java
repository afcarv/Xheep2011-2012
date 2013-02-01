import java.util.Date;
import java.util.ArrayList;

/**
 * Class representing a Ticket (senha)
 */
class Ticket
{
	/**
	 * Static final string defining the type of ticket
	 */
	public String type; 
	/**
	 * Ticket id
	 */
	public int id;
	/**
	 * Date of the ticket
	 */
	public Date date;
	/**
	 * Person that put up the ticket
	 */
	public Person author;
	/**
	 * ArrayList of interventions
	 */
	public ArrayList<Intervention> interventions;

	/**
	 * Constructor
	 */
	public Ticket()
	{
		// incializes the ArrayList
		this.interventions = new ArrayList<Intervention>();
		
		this.id = 0;
		this.date = null;
		this.author = null;
		this.type = "";
	}

	public Ticket(Person author, Date date)
	{
		
		this();
		
		this.author = author;
		this.date = date;
	}
	
	/**
	 * Overloading of toString	
	 */
	public String toString()
	{
		return "id: " + this.id +
		"| type: " + this.type +
		"| author: " + this.author.id +
		"| date: " + this.date;
	}
	
	/**
	 * Check if the Ticket is resolved.
	 * 
	 * @return true if it's resolved. false otherwise
	 */
	public boolean isResolved()
	{
		// if no interventions exit right away with 0
		if (this.interventions.isEmpty()) return false;
		
		//TODO: is this properly indexed?
		if (this.interventions.get(this.interventions.size()-1).resolved == true)
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Returns the number of times the ticket been marked as resolved
	 * 
	 * @return number of times ticket been marked resolved
	 */
	public int timesResolved()
	{
		int count = 0;
		
		// if no interventions exit right away with 0
		if (this.interventions.isEmpty()) return 0;
		
		for (int i = 0; i < this.interventions.size(); i++)
		{
			if (this.interventions.get(i).resolved == true)
			{
				count++;
			}
		}
		
		return count;
	}
	
	/**
	 * Returns the time a ticket took to become resolved.
	 * 
	 * @return time to resolved in miliseconds
	 */
	public long resolveTime()
	{
		if (!this.isResolved()) return 0;

		return this.interventions.get(this.interventions.size()-1).date.getTime() -
			this.interventions.get(0).date.getTime();
	}
}
