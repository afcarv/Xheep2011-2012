/**
 * Application class with CL interface
 * 
 * @author dfof
 * @version 1.0
 */
class Application
{
	/**
	 * Fake enum for MainMenu options
	 */
	public final class MainMenuChoises {
		 public static final int EXIT = 0;
		 public static final int LIST_TICKETS = 1;
		 public static final int EDIT_TICKETS = 2;
		 public static final int NEW_TICKET = 3;
		 public static final int OTHERS = 4;
		 public static final int STATISTICS = 5;
	}
	
	/**
	 * Fake enum for OtherMenu
	 */
	public final class ManageOthersMenuChoises {
		 public static final int EXIT = 0;
		 public static final int USERS = 1;
		 public static final int TECHS = 2;
		 public static final int POSTS = 3;
	}
	
	// list variables
	public PersonList users;
	public PersonList techs;
	public StationList posts;
	public TicketList tickets;
	
	/**
	 * Contructor
	 */
	Application()
	{
		// inicalizes the lists
		users = new PersonList("Pessoas.dat", Person.PersonTypes.USER);
		techs = new PersonList("Pessoas.dat", Person.PersonTypes.WORKER);
		posts = new StationList("Postos_trab.dat");
		
		tickets = new TicketList("Pedidos.txt", "Intervencoes.txt", users, techs, posts);

		// loads files
		posts.loadFile();
		users.loadFile();
		techs.loadFile();
		tickets.loadFile();
	}
	
	/**
	 * exit's the application
	 */
	public void exit()
	{
		// saves posts
		posts.saveFile();
		
		// saves users and techs in one file
		PersonList pl = new PersonList("Pessoas.dat", Person.PersonTypes.ALL);
		
		for (int i = 0; i < users.size(); i++) pl.add(users.get(i));
		for (int i = 0; i < techs.size(); i++) pl.add(techs.get(i));
		pl.saveFile();
		
		tickets.saveFile();
		
		System.exit(0);
	}
	
	/**
	 * Runs the App by showing the main menu handleling
	 * user choises.
	 */
	public void run()
	{		
		for (;/*show menu*/;)
		{
			showMainMenu();
			int opt = User.readInt();
			
			switch (opt)
			{
			case MainMenuChoises.LIST_TICKETS:
				tickets.clPrintAll();
				break;
				
			case MainMenuChoises.EDIT_TICKETS:
				tickets.clEdit();
				break;
				
			case MainMenuChoises.NEW_TICKET:
				tickets.clNew();
				
				
				boolean done;
				do
				{
					done = true;
					System.out.print("Adicionar intervenção? (s/n): ");
					String r = User.readString();
					
					if (!(r.equals("s") || r.equals("n")))
					{
						System.out.println("Escolha invalida.");
						done = false;
					}
					
					if (r.equals("s"))
					{
						tickets.clNewIntervention(tickets.size()-1);
					}
				}
				while (!done);
				break;
				
			case MainMenuChoises.OTHERS:
				manageOthers();
				break;
				
			case MainMenuChoises.STATISTICS:
				showStatistics();
				break;
				
			case MainMenuChoises.EXIT:
				this.exit();
				return;
				
			default:
				System.out.println("opção invalida");
			}
		}
	}
	
	/**
	 * shows the manageOthers menu and handles user
	 * choises.
	 */
	public void manageOthers()
	{
		@SuppressWarnings("unchecked")
		CustomList list = null;
		
		for (;;)
		{
			showManageOthersMenu();
			int op = User.readInt();
			
			switch(op)
			{
			case ManageOthersMenuChoises.USERS:
				list = users;
				break;
			case ManageOthersMenuChoises.TECHS:
				list = techs;
				break;
			case ManageOthersMenuChoises.POSTS:
				list = posts;
				break;
			case ManageOthersMenuChoises.EXIT:
				return;
				
			default:
				System.out.println("Opção invalida");
			}
			
			String eop;
			do
			{
				System.out.println("## Listagem ##");
				list.clPrintAll();
				showEditOptions();
				eop = User.readString();
				
				// makes sure there's something there
				if (eop.length() != 1) eop = "i";
				
				switch(eop.charAt(0))
				{
				case 'n':
					list.clNew();
					break;
				case 'e':
					list.clEdit();
					break;
				case 'a':
					list.clDelete();
					break;
					
				case 'v':
					break;
					
				default:
					System.out.println("Opcao invalida.");
				}
				
			} 
			while (eop.charAt(0) != 'v');
		}
	}
	
	/**
	 * Shows some statistics as specified in requirements
	 */
	public void showStatistics()
	{
		System.out.println("## Estatisticas ##");
		
		System.out.println("Numero de pedidos no sistema: " + tickets.size());
		System.out.println("Numero de pedidos resolvidos: " + tickets.resolvedCount());
		
		System.out.println("Numero de intervenções medio: " + tickets.averageInterventions(false));
		System.out.println("Numero de intervenções medio em pedidos resolvidos: " + tickets.averageInterventions(true));
		System.out.println("Tempo medio de resolução: " + tickets.averageResolveTime() + " minutos");
		
		System.out.println("");
	}

	/**
	 * Prints the main menu
	 */
	public void showMainMenu()
	{
		System.out.println("## Menu Principal ##");
		System.out.println("1) Listar Pedidos");
		System.out.println("2) Ver/Editar Pedidos");
		System.out.println("3) Novo Pedido");
		System.out.println("---------------");
		System.out.println("4) Gerir outros dados");
		System.out.println("5) Estatisticas");
		System.out.println("---------------");
		System.out.println("0) sair");
	}
	
	/**
	 * Prints the ManageOthers menu
	 */
	public void showManageOthersMenu()
	{
		System.out.println("## Gerir outros dados ##");
		System.out.println("1) Utilizadores");
		System.out.println("2) Tecnicos");
		System.out.println("3) Postos de Trabalho");
		System.out.println("---------------");
		System.out.println("0) sair");
	}
	
	/**
	 * Prints edit options
	 */
	public void showEditOptions()
	{
		System.out.print("Opcoes: ");
		System.out.print("(e)ditar, ");
		System.out.print("(n)ovo, ");
		System.out.print("(a)pagar, ");
		System.out.println("(v)oltar ao menu.");
	}
}