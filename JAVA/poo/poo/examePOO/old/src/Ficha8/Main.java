package Ficha8;

import java.util.ArrayList;

class Main {

	/**
	 * @param args
	 */
	public static void main(String args[])
	{	
		GestaoContactos gc = new GestaoContactos();
		
		for(;/*menu loop*/;)
		{
			switch(showMenu())
			{
			case 1:
				gc.AdicionaContacto();
				break;
			
			case 2:
				gc.EliminaContacto();
				break;
				
			case 3:
				gc.ListarContactos();
				break;
			//case 5:
				//gc.ListarVelho();
				//break;	
			case 7:
			{
				ArrayList<Contacto> aniv = gc.aniversarios();
				
				for (int i = 0; i < aniv.size(); i++)
				{
					System.out.println(aniv.get(i));
				}
				
				break;	
			}
				
			case 0:
				return;		
				
			default:
				System.out.println("Opção invalida!");
			}
		}	
	}
	private static int showMenu() {
		System.out.println("--< Gestão de Contactos >--");
		System.out.println("1. Adicionar Contacto.");
		System.out.println("2. Apagar Contacto.");
		System.out.println("3. Listar Contactos.");
		//System.out.println("4. Listar todos os Contactos.");
		//System.out.println("5. Visualizar Contacto mais velho.");
		//System.out.println("6. Visualizar pessoas que são amigos e colegas de trabalho.");
		System.out.println("7. Visualizar Contactos com o aniversário a aproximar-se.");
		System.out.println("0. Sair");
		System.out.println("--------------------------");
		System.out.print(">>");
		
		return User.readInt();
	}
}



