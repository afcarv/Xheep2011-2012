import java.io.Serializable;

/**
 * Class Representing a person.
 */
class Person implements Serializable
{
	/**
	 * required for serialization
	 */
	private static final long serialVersionUID = -2286451351076678805L;	
	
	/**
	 * Fake enum for PersonTypes
	 */
	public final class PersonTypes {
		 public static final int ALL = 0;
		 public static final int USER = 1;
		 public static final int WORKER = 2;
	}
	
	/**
	 * Id of the Object
	 */
	public int id;
	/**
	 * Name of the person (must be unique)
	 */
	public String name;
	/**
	 * Person type of a PersonTypes value
	 */
	public int type;
	
	Person()
	{
		this.id = 0;
		this.name = "";
	}
	
	Person(int type, String name)
	{
		this();
		this.type = type;
		this.name = name;
	}	

	public String toString()
	{
		return "id: " + this.id +
			"| type: " +this.type +
			"| name: " + this.name;
	}
}