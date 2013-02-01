import java.io.*;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Calendar;
import java.util.HashMap;
import java.util.Map;
import java.util.StringTokenizer;


/**
 * Custom List based on CustomList for holding Ticket Objects.
 *
 * @author dfof
 * @version 1.0
 */
class TicketList extends CustomList<Ticket>
{
	/**
	 * Required for serialization
	 */
	private static final long serialVersionUID = -900755006490712879L;
	/**
	 * File were the interventions are saved
	 */
	public String interventionFile;
	/**
	 * "Pointer" to the list of Stations
	 */
	private StationList posts;
	/**
	 * "Pointer" to the list of technician
	 */
	private PersonList techs;
	/**
	 * "Pointer to the list of users
	 */
	private PersonList users;
	
	TicketList()
	{
		super();
		
		this.interventionFile = "";
		this.users = null;
		this.techs = null;
		this.posts = null;		
	}

	TicketList(String ticketFile, String interventionFile, PersonList users, PersonList techs, StationList posts)
	{
		super(ticketFile);
		this.interventionFile = interventionFile;
		this.users = users;
		this.techs = techs;
		this.posts = posts;
	}
		
	public boolean add(Ticket t)
	{
		t.id = this.lastid;
		return super.add(t);
	}
	
	public Ticket getById(int id)
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
	
	/**
	 * Returns the number of tickets that are resolved.
	 * 
	 * @return number of tickets resolved
	 */
	public int resolvedCount()
	{
		int count = 0;
		
		for (int i = 0; i < this.size(); i++)
		{
			if (this.get(i).isResolved())
			{
				count++;
			}
		}
		
		return count;
	}
	
	/**
	* Returns the average resolve time for the all the tickets.
	*
	* @return average Average resolve time of all the tickets
	*/
	public float averageResolveTime()
	{
		return averageResolveTime(new Date(0), Calendar.getInstance().getTime());
	}
	
	/**
	* Returns the average resolve time for the tickets in starting from the
	* given date.
	*
	* @param begin Begining date
	*
	* @return average Average resolve time of the tickets 
	*/
	public float averageResolveTime(Date begin)
	{
		return averageResolveTime(begin, Calendar.getInstance().getTime());
	}
	
	/**
	* Returns the average resolve time for the tickets in the given
	* time window.
	*
	* @param begin Begining date of the window
	* @param end Ending date of the window
	*
	* @return average Average resolve time of the tickets in the given window
	*/
	public float averageResolveTime(Date begin, Date end)
	{	
		float avg = 0;
		int total = 0;
		
		// in case there's are no tickets return 0 right away
		if (this.isEmpty()) return avg;
		
		for (int i = 0; i < this.size(); i++)
		{
			// not inclusive
			if (get(i).date.after(begin) && get(i).date.before(end))
			{
				if (this.get(i).isResolved())
				{
					avg += this.get(i).resolveTime();
					total++;
				}
			}
		}
		
		return 	avg/(float)total;
	}
	
	/**
	* Returns the average number of interventions for the tickets. If the resolved flag is true
	* will only show resolved tickets.
	*
	* @param resolved true if you only want the resolved tickets
	* @return average Average number of intervention
	*/
	public float averageInterventions(boolean resolved)
	{		
		return averageInterventions(resolved, new Date(0), Calendar.getInstance().getTime());
	}
	
	/**
	 * Returns the average number of interventions for the tickets starting on
	 * given date. window. If the resolved flag is true will only show resolved tickets.
	 *
	 * @param resolved true if you only want the resolved tickets
	 * @param begin Begining date
	 * 
	 * @return average Average number of intervention
	 */
	public float averageInterventions(boolean resolved, Date begin)
	{
		return averageInterventions(resolved, begin, Calendar.getInstance().getTime());
	}
	
	/**
	 * Returns the average number of interventions for the tickets in the given
	 * time window. If the resolved flag is true will only show resolved tickets.
	 *
	 * @param resolved true if you only want the resolved tickets
	 * @param begin Begining date of the window
	 * @param end Ending date of the window
	 *
	 * @return average Average number of intervention in the given window
	 */
	public float averageInterventions(boolean resolved, Date begin, Date end)
	{
		int count = 0;
		int total = 0;
		
		// avoid doing useless work
		if (this.isEmpty()) return 0;
		
		for (int i = 0; i < this.size(); i++)
		{
			// not inclusive
			if (this.get(i).date.after(begin) && this.get(i).date.before(end))
			{
				if((resolved && this.get(i).isResolved()) || !resolved)
				{
					count += this.get(i).interventions.size();
					total++;
				}
			}
		}
		
		return (float)count/(float)total;	
	}
	
	public int loadFile()
	{
		SimpleDateFormat df = new SimpleDateFormat("EEE MMM dd HH:mm:ss zzz yyyy");

		int readCount = 0;
		String line;
		
		try // Read tickets
		{	
			FileInputStream fis = new FileInputStream(this.filename);
			InputStreamReader in = new InputStreamReader(fis, "UTF-8");
			
			BufferedReader iTickets = new BufferedReader(in);
			
			while (null != (line = iTickets.readLine()))
			{				
				// parce line
				Map<String, String> properties = this.parseLine(line, 5, 7);
				if (null == properties) continue; // invalid parse
				
				try // property access
				{
					Ticket t = null;
					
					if (properties.get("type").equals("system"))
					{
						t = new SystemTicket();
						
						((SystemTicket)t).description = properties.get("description");
						((SystemTicket)t).station = posts.getById(Integer.valueOf(properties.get("station")));
						
						// station can't be null
						if (((SystemTicket)t).station == null) continue;
					}
					if (properties.get("type").equals("trainning"))
					{
						t = new TrainningTicket();
						
						((TrainningTicket)t).topic = properties.get("topic");
					}
					
					// common properties
					t.id = Integer.valueOf(properties.get("id"));
					t.author = users.getById(Integer.valueOf(properties.get("author")));
					if (t.author == null) continue;
					
					try // Parse date
					{
						t.date = df.parse(properties.get("date"));
					}
					catch (ParseException e)
					{
						continue;
					}
					
					readCount++;
					this.add(t);
				}
				catch (NumberFormatException e)
				{
					continue;
				}
				catch (NullPointerException e)
				{
					continue;
				}
			}
			iTickets.close();			
		}
		catch (FileNotFoundException e)
		{
			return 0;
		}
		catch (IOException e)
		{
			e.printStackTrace();
		}
		
		try // Read interventions
		{
			FileInputStream fis = new FileInputStream(this.interventionFile);
			InputStreamReader in = new InputStreamReader(fis, "UTF-8");
			
			BufferedReader iInterventions = new BufferedReader(in);
			
			while (null != (line = iInterventions.readLine()))
			{
				// parce line
				Map<String, String> properties = this.parseLine(line, 6, 6);
				if (null == properties) continue; // invalid parse
				
				try // access properties
				{
					Ticket t = this.getById(Integer.valueOf(properties.get("ticket")));
					
					// invalid ticket
					if (t == null) continue;
					Intervention iv = new Intervention();
					
					try
					{
						iv.date = df.parse(properties.get("date"));
					}
					catch (ParseException e)
					{
						continue;
					}
					
					iv.technician = techs.getById(Integer.valueOf(properties.get("technician")));
					if (iv.technician == null) continue;
					
					iv.duration = Integer.valueOf(properties.get("duration"));
					iv.resolved = Boolean.valueOf(properties.get("resolved"));
					iv.description = properties.get("description");
					
					t.interventions.add(iv);
				}
				catch (NumberFormatException e)
				{
					continue;
				}
				catch (NullPointerException e)
				{
					continue;
				}
			}
			iInterventions.close();
		}
		catch (FileNotFoundException e)
		{
			System.out.println("Aviso: Ficheiro das intervenções não foi encontrado.");
			return readCount;
		}
		catch (IOException e)
		{
			e.printStackTrace();
		}	
		
		return readCount;
	}
	
	public int saveFile()
	{
		int writeCount = 0;

		try
		{
			FileOutputStream fos1 = new FileOutputStream(this.filename);
			FileOutputStream fos2 = new FileOutputStream(this.interventionFile);
			
			OutputStreamWriter out1 = new OutputStreamWriter(fos1, "UTF-8");
			OutputStreamWriter out2 = new OutputStreamWriter(fos2, "UTF-8");
			
			Writer oTickets = new BufferedWriter(out1);
			Writer oInterventions = new BufferedWriter(out2);
			
			for (int i = 0; i < this.size(); i++)
			{
				// writes the ticket line
				oTickets.write(this.get(i).toString() + "\n");
				writeCount++;
				
				if (this.get(i).interventions.isEmpty()) continue;				
				for (int j = 0; j < this.get(i).interventions.size(); j++)
				{
					// writes the interventions
					oInterventions.write("ticket: " + this.get(i).id + "| " +
							this.get(i).interventions.get(j).toString() + "\n");
				}
				
			}
			
			oTickets.close();
			oInterventions.close();
		}
		catch (Exception e)
		{
			e.printStackTrace();
			return 0;
		}
		return writeCount;
	}
	
	public void clPrintAll()
	{
		String formating = "%-3s|%-10s|%-30s|%-4s|%-30s|%-10s|%-10s|%s\n";
		Ticket t;
		
		// prints header
		if (this.isEmpty())
		{
			System.out.println("Nao a tickets.");
		}
		else
		{
			System.out.printf(formating,
					"id",
					"tipo",
					"autor",
					"int",
					"topico/descrição",
					"posto",
					"resolvido",
					"data"
				);
		}
		
		for (int i = 0; i < this.size(); i++)
		{
			t = this.get(i);
			
			String extended = "";
			String post = "";
			
			if (t.type.equals("system"))
			{
				extended = ((SystemTicket)t).description;
				post = String.valueOf(((SystemTicket)t).station.id);
			}
			if (t.type.equals("trainning"))
			{
				extended = ((TrainningTicket)t).topic;
			}
			
			System.out.printf(formating,
					t.id,
					t.type,
					t.author.name,
					t.interventions.size(),
					extended,
					post,
					String.valueOf(t.isResolved()),
					t.date
				);
		}
		System.out.println("");
	}
	
	public void clPrint(int id)
	{
		int pos;
		if (0 <= (pos = this.findId(id)))
		{
			Ticket t = this.get(pos);
			
			System.out.println("id: " + t.id);
			System.out.println("tipo: " + t.type);
			System.out.println("autor: " + t.author.name);
			System.out.println("data: " + t.date);
			
			if (t.type.equals("system"))
			{
				System.out.println("descrição: " + ((SystemTicket)t).description);
				System.out.println("posto: " + ((SystemTicket)t).station.name);
			}
			if (t.type.equals("trainning"))
			{
				System.out.println("topico: " + ((TrainningTicket)t).topic);
			}
			
			System.out.println("Intervenções:");
			this.clPrintAllInterventions(pos);
		}
	}
	
	public boolean clNew()
	{
		Ticket t;
		boolean done;
		
		if (users.isEmpty() || techs.isEmpty())
		{
			System.out.println("Precisa de adicional utilizadores e/ou tecnicos primeiro");
			return false;
		}
		
		System.out.print("Tipo de pedido (s)istema/(f)ormação: ");
		String opt = User.readString();
		
		if (opt.length() != 1)
		{
			System.out.println("Tipo de pedido desconhecido");
			return false;
		}
		if (!(opt.charAt(0) == 's' || opt.charAt(0) == 'f'))
		{
			System.out.println("Tipo de pedido desconhecido");
			return false;
		}
		
		if (opt.charAt(0) == 's')
		{
			if (posts.isEmpty())
			{
				System.out.println("Precisa de addicionar postos primeiro");
				return false;
			}
			
			t = new SystemTicket();
		}
		else
		{
			t = new TrainningTicket();
		}
	
		// current date
		t.date = new Date(Calendar.getInstance().getTimeInMillis());
		
		do
		{
			done = true;
			users.clPrintAll();
			System.out.print("id do autor: ");
			int id = User.readInt();
			
			if (null == (t.author = users.getById(id)))
			{
				System.out.println("Id invalida");
				done = false;
				continue;
			}
		}
		while (!done);
		
		// trainning only fields
		if (opt.charAt(0) == 'f')
		{
			System.out.print("topico: ");
			((TrainningTicket)t).topic = User.readString();
		}
		else
		{
			// system only fields
			System.out.print("descrição: ");
			((SystemTicket)t).description = User.readString();
			
			do
			{
				done = true;
				posts.clPrintAll();
				System.out.print("id do posto: ");
				int id = User.readInt();
				
				if (null == (((SystemTicket)t).station = posts.getById(id)))
				{
					System.out.println("Id invalida");
					done = false;
					continue;
				}
			}
			while (!done);
		}
		
		this.add(t);
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
		
		String eop;
		do
		{
			this.clPrint(id);
			System.out.print("Opcoes: editar (p)edido, Intervenções: (n)ova, ");
			System.out.println("(e)ditar, (a)pagar, (v)oltar ao menu.");
			eop = User.readString();
			
			// makes sure there's something there
			if (eop.length() != 1) eop = "i";
			
			switch(eop.charAt(0))
			{
			case 'n':
				this.clNewIntervention(pos);
				break;
			case 'e':
				this.clEditIntervention(pos);
				break;
			case 'a':
				this.clDeleteIntervention(pos);
				break;
				
			case 'p':
				this.clEditTicket(pos);
				break;
				
			case 'v':
				break;
				
			default:
				System.out.println("Opcao invalida.");
			}
			
		} 
		while (eop.charAt(0) != 'v');
		return true;
	}
	
	/**
	 * Prompts in the command line for updated fields
	 * of the element with the given id.
	 * 
	 * @param index of the Ticket
	 * @return true if sucessfull. false on error
	 */
	public boolean clEditTicket(int index)
	{
		Ticket t = this.get(index);
		
		boolean done;
		do
		{
			done = true;
			users.clPrintAll();
			System.out.print("id do autor[" +  t.author.id + "]: ");
			int id = User.readInt();
			
			if (null == users.getById(id))
			{
				System.out.println("Id invalida");
				done = false;
				continue;
			}
			else
			{
				t.author = users.getById(id);
			}
		}
		while (!done);
		
		// trainning only fields
		if (t.type.equals("trainning"))
		{
			System.out.print("topico [" + ((TrainningTicket)t).topic + "]: ");
			((TrainningTicket)t).topic = User.readString();
		}
		if (t.type.equals("system"))
		{
			// system only fields
			System.out.print("descrição [" + ((SystemTicket)t).description + "]: ");
			((SystemTicket)t).description = User.readString();
			
			do
			{
				done = true;
				posts.clPrintAll();
				System.out.print("id do posto [" + ((SystemTicket)t).station.id + "]: ");
				int id = User.readInt();
				
				if (null == posts.getById(id))
				{
					System.out.println("Id invalida");
					done = false;
					continue;
				}
				else
				{
					((SystemTicket)t).station = posts.getById(id);
				}
			}
			while (!done);
		}	
		return true;
	}
	
	/**
	 * Prints all the interventions of a given Ticket
	 * 
	 * @param index of the Ticket
	 */
	public void clPrintAllInterventions(int index)
	{
		String formating = "%-3s|%-15s|%-10s|%-30s|%-10s|%s\n";
		
		Ticket t = this.get(index);
		
		if (t.interventions.isEmpty())
		{
			System.out.println("Nao a intervenções.");
		}
		else
		{
			System.out.printf(formating,
					"id",
					"tecnico",
					"duração",
					"descrição",
					"resolvido",
					"data"
				);
		}
		
		for (int i = 0; i < t.interventions.size(); i++)
		{
			Intervention iv = t.interventions.get(i);
			
			System.out.printf(formating,
					i,
					iv.technician.name,
					iv.duration,
					iv.description,
					iv.resolved,
					iv.date
				);
		}
		System.out.println("");	
	}
	
	/**
	 * Prompts in the command line for a new element
	 * on the list and adds it.
	 * 
	 * @param index of the Ticket
	 * @return true if sucessfull. false on error
	 */
	public boolean clNewIntervention(int index)
	{
		Ticket t = this.get(index);
		Intervention iv = new Intervention();		
		boolean done;
		
		// date
		iv.date = Calendar.getInstance().getTime();
		
		do
		{
			done = true;
			techs.clPrintAll();
			System.out.print("id do tecnico: ");
			int id = User.readInt();
			
			if (null == (iv.technician = techs.getById(id)))
			{
				System.out.println("Id invalida");
				done = false;
				continue;
			}
		}
		while (!done);
		
		System.out.print("Duração (min): ");
		iv.duration = User.readInt();
		
		System.out.print("Descrição: ");
		iv.description = User.readString();
		
		do
		{
			done = true;
			System.out.print("Resolvido? (s/n): ");
			String rep = User.readString();
			
			if (!(rep.equals("s") || rep.equals("n")))
			{
				System.out.println("resposta errada.");
				done = false;
				continue;
			}
			else
			{
				iv.resolved = (rep.equals("s"))? true : false;
			}
		}
		while(!done);
		return t.interventions.add(iv);
	}
	
	/**
	 * Prompts in the command line for updated fields
	 * of the element with the given id.
	 * 
	 * @param index of the Ticket
	 * @return true if sucessfull. false on error
	 */
	public boolean clEditIntervention(int index)
	{
		Ticket t = this.get(index);
		Intervention iv = null;
		boolean done;
		
		System.out.print("id da intervenção: ");
		int pos = User.readInt();
		try
		{
			iv = t.interventions.get(pos);
		}
		catch (IndexOutOfBoundsException e)
		{
			System.out.println("Intervenção não existe.");
			return false;
		}
		
		do
		{
			done = true;
			techs.clPrintAll();
			System.out.print("id do tecnico ["+ iv.technician.id + "]: ");
			int id = User.readInt();
			
			if (null == techs.getById(id))
			{
				System.out.println("Id invalida");
				done = false;
				continue;
			}
			else
			{
				iv.technician = techs.getById(id);
			}
		}
		while (!done);
		
		System.out.print("Duração (min) ["+ iv.duration +": ");
		iv.duration = User.readInt();
		
		System.out.print("Descrição [" + iv.description + "]: ");
		iv.description = User.readString();
		
		do
		{
			done = true;
			System.out.print("Resolvido? (s/n) ["+ iv.resolved + "]: ");
			String rep = User.readString();
			
			if (!(rep.equals("s") || rep.equals("n")))
			{
				System.out.println("resposta errada.");
				done = false;
				continue;
			}
			else
			{
				iv.resolved = (rep.equals("s"))? true : false;
			}
		}
		while(!done);
		return false;
	}
	
	/**
	 * Prompts in the command line for comfirmation
	 * and deletes the element.
	 * 
	 * @param index of the Ticket
	 * @return true if sucessfull. false on error
	 */
	public boolean clDeleteIntervention(int index)
	{
		Ticket t = this.get(index);
		
		System.out.print("id da intervenção: ");
		int id = User.readInt();
		
		try
		{
			t.interventions.remove(id);
		}
		catch (IndexOutOfBoundsException e)
		{
			System.out.println("Intervenção não existe.");
			return false;
		}
	
		return true;
	}
	
	/**
	 * Parces a line for a properties.
	 * 
	 * @param line to parse
	 * @param minCount Minimal number of properties expected
	 * @param maxCount Maximum amound of properties expected
	 * @return Map of properties or null if amound of elements found is out of bounds
	 */
	private Map<String, String> parseLine(String line, int minCount, int maxCount)
	{
		StringTokenizer st = new StringTokenizer(line, "|");
		Map<String, String> dic = new HashMap<String, String>();
		
		// out of bounds
		if (!(st.countTokens() >= minCount && st.countTokens() <= maxCount)) return null;
		
		while (st.hasMoreTokens())
		{
			String key = "";
			String value = "";
			
			StringTokenizer item = new StringTokenizer(st.nextToken(), ":");
			if (item.countTokens() < 2) continue; // invalid item
			
			key = item.nextToken();
			value = item.nextToken();
			
			// in case there's more ':' after the first
			while (item.hasMoreTokens())
			{
				value += ":" + item.nextToken();
			}
			
			// trims white spaces
			key = key.trim();
			value = value.trim();
			
			dic.put(key, value);
		}
		
		// out of bounds
		if (!(dic.size() >= minCount && dic.size() <= maxCount)) return null;
		return dic;
	}
}
