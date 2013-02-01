import java.io.EOFException;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;

/**
 * Custom List for holding database like Objects.
 *
 * @author dfof
 * @version 1.0
 */
class PersonList extends CustomList<Person>
{
	/**
	 * required for serialization
	 */
	private static final long serialVersionUID = -3502716191976118845L;
	
	/**
	 * Type of person we're storing
	 */
	public int type;
	
	PersonList()
	{
		super();
		this.type = Person.PersonTypes.ALL;
	}
	
	PersonList(String filename, int type)
	{
		super(filename);
		this.type = type;
	}

	public boolean add(Person p)
	{
		if (this.type == Person.PersonTypes.ALL || p.type == this.type)
		{
			p.id = this.lastid;
			return super.add(p);
		}
		return false;
	}
	
	public Person getById(int id)
	{
		for (int i = 0; i < this.size(); i++)
		{
			if (id == this.get(i).id)
			{
				return this.get(i);
			}
		}
		
		return null;
	}
	
	public int findId(int id)
	{
		for (int i = 0; i < this.size(); i++)
		{
			if (id == this.get(i).id)
			{
				return i;
			}
		}
		
		return -1;
	}
	
	public int loadFile()
	{
		try
		{
			FileInputStream fis = new FileInputStream(this.filename);
			ObjectInputStream ois = new ObjectInputStream(fis);

			for (;;)
			{
				Person p = (Person)ois.readObject();
				
				if (p.type == Person.PersonTypes.ALL || p.type == this.type)
				{
					if (p.id > this.lastid)
					{
						this.lastid = p.id;
					}
					this.add(p);
				}
			}

		}
		catch (FileNotFoundException e)
		{
			return 0;
		}
		catch (EOFException e)
		{
			return this.size();
		}
		catch (ClassNotFoundException e)
		{
			return this.size();
		}
		catch (IOException e)
		{
			e.printStackTrace();
		}
		return this.size();
	}
	
	public int saveFile()
	{
		// if empty nothing to save
		if (this.isEmpty()) return 0;
		int writeCount = 0;

		try
		{
			// opens in append mode
			FileOutputStream fos = new FileOutputStream(this.filename);
			ObjectOutputStream oos = new ObjectOutputStream(fos);
			
			for (int i = 0; i < this.size(); i++)
			{
				oos.writeObject(this.get(i));
				writeCount++;
			}			
			
			oos.close();
			fos.close();
		}
		catch (IOException e)
		{
			e.printStackTrace();
		}
		return writeCount;
	}
	
	public void clPrintAll()
	{
		String formating = "%-3s|%-30s\n";
		Person p;
		
		// prints header		
		if (this.isEmpty())
		{
			System.out.print("Nao a ");
			
			System.out.println(
				(this.type == Person.PersonTypes.USER)?
						"Utilizador" :
						"Tecnico"
			);
		}
		else
		{
			System.out.printf(formating,
					"id",
					"nome"
				);
		}
		
		for (int i = 0; i < this.size(); i++)
		{
			p = this.get(i);
			
			System.out.printf(formating,
					p.id,
					p.name
				);
		}
		System.out.println("");
	}
	
	public void clPrint(int id)
	{
		int pos;
		if (0 <= (pos = this.findId(id)))
		{
			Person p = this.get(pos);
			
			System.out.println("nome: " + p.name);
		}
	}
	
	public boolean clNew()
	{
		Person p = new Person();
		p.type = this.type;
		
		boolean done;
		do
		{
			done = true;
			System.out.print("nome: ");
			p.name = User.readString();
			
			for (int i = 0; i < this.size(); i++)
			{
				if (this.get(i).name.equals(p.name))
				{
					System.out.println("nome já existe, escolher outro.");
					done = false;
				}
			}
		}
		while (!done);
		
		this.add(p);
		return true;
	}
	
	public boolean clEdit(int id)
	{
		int pos;
		if (0 > (pos = this.findId(id)))
		{
			System.out.println("Id não existe.");
			return false;
		}
		
		Person p = this.get(pos);
		
		System.out.print("nome ["+ p.name +"]: ");
		p.name = User.readString();
		return true;
	}
}