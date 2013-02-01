import java.io.*;

/**
 * Custom List for holding database like Objects.
 *
 * @author dfof
 * @version 1.0
 */
class StationList extends CustomList<Station>
{
	/**
	 * Required for serialization
	 */
	private static final long serialVersionUID = 1350364189904060519L;
	
	
	public StationList(String filename)
	{
		super(filename);
	}

	public boolean add(Station s)
	{
		s.id = this.lastid;
		return super.add(s);
	}
	
	public Station getById(int id)
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
				Station s = (Station)ois.readObject();
				
				
				if (s.id > this.lastid)
				{
					this.lastid = s.id;
				}
				
				this.add(s);
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
		String formating = "%-3s|%-20s|%-30s|%-15s|%-6s|%-5s\n";
		Station s;
		
		// prints header
		if (this.isEmpty())
		{
			System.out.println("Nao a postos de trabalho");
		}
		else
		{
			System.out.printf(formating,
					
					"id",
					"name",
					"os",
					"cpu",
					"ram",
					"hdd"
				);
		}
		
		for (int i = 0; i < this.size(); i++)
		{
			s = this.get(i);
			
			System.out.printf(formating,
					s.id,
					s.name,
					s.os,
					s.cpu,
					s.ram,
					s.hdd
				);
		}
		System.out.println("");
	}
	
	public void clPrint(int id)
	{
		int pos;
		if (0 <= (pos = this.findId(id)))
		{
			Station s = this.get(pos);
			
			System.out.println("nome: " + s.name);
			System.out.println("os: " + s.os);
			System.out.println("cpu: " + s.cpu);
			System.out.println("ram: " + s.ram);
			System.out.println("hdd: " + s.hdd);
		}
	}
	
	public boolean clNew()
	{
		Station s = new Station();
		
		boolean done;
		do
		{
			done = true;
			System.out.print("nome: ");
			s.name = User.readString();
			
			for (int i = 0; i < this.size(); i++)
			{
				if (this.get(i).name.equals(s.name))
				{
					System.out.println("nome já existe, escolher outro.");
					done = false;
				}
			}
		}
		while (!done);
		
		System.out.print("os: ");
		s.os = User.readString();
		System.out.print("cpu: ");
		s.cpu = User.readString();
		System.out.print("hdd (gb): ");
		s.hdd = User.readFloat();
		System.out.print("ram (gb): ");
		s.ram = User.readFloat();
		
		this.add(s);
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
		
		Station s = this.get(pos);

		System.out.print("nome ["+ s.name +"]: ");
		s.name = User.readString();
		System.out.print("os ["+ s.os +"]: ");
		s.os = User.readString();
		System.out.print("cpu ["+ s.cpu +"]: ");
		s.cpu = User.readString();
		System.out.print("hdd ["+ s.hdd +"](gb): ");
		s.hdd = User.readFloat();
		System.out.print("ram ["+ s.ram +"[(gb): ");
		s.ram = User.readFloat();
		return true;
	}
}
