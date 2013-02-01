import java.io.File;
import java.util.ArrayList;

/**
* Custom List for holding database like Objects.
*
* @author dfof
* @version 1.0
*/
class CustomList<E> extends ArrayList<E>
{
	/**
	 * required to extend ArrayList
	 */
	private static final long serialVersionUID = -228729089018569665L;	
	
	/**
	 * File used by loadFile, saveFile and clearFile
	 */
	public String filename;
	
	/**
	 * last ID used
	 */
	protected int lastid;	
	
	/**
	* Contructor. Inicializes protected lastId.
	*/
	CustomList()
	{
		this.lastid = 0;
	}
	
	CustomList(String filename)
	{
		this();
		this.filename = filename;
	}
	
	/**
	* get's the last id used on.	
	*
	* @return id returns the last id used in the list.
	*/
	public int getLastid()
	{
		return this.lastid;
	}
	
	/**
	 * Returns an object element given it's id.
	 * 
	 * @param id of the element
	 * @return object if found. null otherwise
	 */
	public E getById(int id)
	{
		// Implemented by extendor
		return null;
	}
	
	/**
	 * Returns the position of an element given it's id.
	 * 
	 * @param id of the element
	 * @return position of the element. negative value if not found.
	 */
	public int findId(int id)
	{
		// Implemented by extendor
		return -1;
	}
	
	/**
	* Add's an element to the list. By adding the element the lastId will be
	* incremented and used to overide the .id member of the given object.
	*
	* @param Object Object to be added, note that the oject must have a public
	*        id property or the add will fail.
	*
	* @return added returns true if the  
	*/
	public boolean add(E o)
	{
		lastid++;		
		return super.add(o);		
	}
	
	/**
	 * Delete's an element of the list by id
	 * 
	 * @param id of the element
	 * @return true if sucessfull. false on error
	 */
	public boolean delete(int id)
	{
		int pos;
		if (0 < (pos = this.findId(id)))
		{
			remove(pos);
			return true;
		}

		return false;
	}
	
	/**
	 * Overide of toString
	 */
	public String toString()
	{
		String output = "";
		
		for (int i = 0; i < this.size(); i++)
		{
			output += this.get(i).toString();
		}
		
		return output;
	}
	
	/**
	* Load's a list from a file. The function uses the filename property as
	* the target from were to load the file. it will then attempt to read
	* object's from it and add them to the list.
	*
	* @return readCount number of elements read from file, in case of failure
	*         0 will be returned and the apropriate exeption will be trown.
	*/
	public int loadFile()
	{
		// Implemented by extendor
		return 0;
	}
	
	/**
	* Save's the list to a file. Will use the file indicated in public 
	* property filename to save.
	*
	* @return writeCount number of elements writen to the file, in case of
	*         failure 0 will be returned and the apropriate exeption will be
	*         trown.
	*/
	public int saveFile()
	{
		// Implemented by extendor
		return 0;
	}
	
	/**
	 * Clears the file of it's content. It will open the file and overwrite it
	 * with empty content.
	 * 
	 * @return 0 on sucess other on failure
	 */
	public int clearFile()
	{
		if (this.filename == null) return -1;
		try
		{
			File file = new File(this.filename);
			
			if (file.exists())
			{
				file.delete();
			}
		}
		catch (Exception e)
		{
			e.printStackTrace();
			return 1;
		}	
		return 0;
	}
	
	/**
	 * Outputs to stdout a formated list of content.
	 */
	public void clPrintAll()
	{
		// Implemented by extendor
	}
	
	/**
	 * Prompts on the command line for an id of an element
	 * and them prints it in stdout.
	 */
	public void clPrint()
	{
		System.out.print("id: ");
		int id = User.readInt();
		
		if (0 < this.findId(id))
		{
			this.clPrint(id);
		}
		else
		{
			System.out.println("Id não existe.");
		}
	}
	
	/**
	 * Outputs to stdout a formated element by id.
	 * 
	 * @param id of element in list
	 */
	public void clPrint(int id)
	{
		// Implemented by extendor
	}
	
	/**
	 * Prompts in the command line for a new element
	 * on the list and adds it.
	 * 
	 * @return true if sucessfull. false on error
	 */
	public boolean clNew()
	{
		// Implemented by extendor
		return false;
	}
	
	/**
	 * Prompts in the command line for an element
	 * and requests updated fields for it.
	 * 
	 * @return true if sucessfull. false on error
	 */
	public boolean clEdit()
	{
		System.out.print("id: ");
		int id = User.readInt();
		
		return this.clEdit(id);
	}
	
	/**
	 * Prompts in the command line for updated fields
	 * of the element with the given id.
	 * 
	 * @param id of the element 
	 * @return true if sucessfull. false on error
	 */
	public boolean clEdit(int id)
	{
		// Implemented by extendor
		return false;
	}
	
	/**
	 * Prompts in the command line for an element
	 * and asks for comfirmation before deleting it.
	 * 
	 * @return true if sucessfull. false on error
	 */
	public boolean clDelete()
	{
		System.out.print("id: ");
		int id = User.readInt();
		
		return this.clDelete(id);
	}
	
	/**
	 * Prompts in the command line for comfirmation
	 * and deletes the element.
	 * 
	 * @param id of the element 
	 * @return true if sucessfull. false on error
	 */
	public boolean clDelete(int id)
	{
		int pos;
		if (0 > (pos = this.findId(id)))
		{
			System.out.println("id não existe.");
			return false;
		}
		
		this.clPrint(id);
		System.out.println("Tem a certesa que quer apagar (s/n)?");
		char op = User.readString().charAt(0);
		
		if (op == 's')
		{
			this.remove(pos);
			return true;
		}
		return false;
	}
}
