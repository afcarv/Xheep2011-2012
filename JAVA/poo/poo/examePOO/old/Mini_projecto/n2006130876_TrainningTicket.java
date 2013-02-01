import java.util.Date;

/**
 * Class representing a TrainningTicket (pedido de formação)
 */
class TrainningTicket extends Ticket
{
	/**
	 * Topic of the training required
	 */
	public String topic;

	/**
	 *	Contructor
	 */
	TrainningTicket()
	{
		super();
		this.type = "trainning";
		this.topic = "";
	}
	
	TrainningTicket(Person author, Date date, String topic)
	{
		super(author, date);
		
		
		this.topic = topic;
	}
	
	public String toString()
	{
		return super.toString() +
		"| topic: " + this.topic;
	}
}
