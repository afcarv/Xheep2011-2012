import java.util.ArrayList;


public class Main {
	
	private enum Option {
		Quit,
		UpdateDay,		
	}
	
	public static void main(String args[])
	{
		ArrayList<Empregado> list = new ArrayList<Empregado>();
		
		for(;/*menu loop*/;)
		{
			switch(showMenu())
			{
			
			case Quit:
				return;			
			}
		}
	}
	
	public static Option showMenu()
	{
		System.out.println("");
		
		return Option.Quit;
	}
}
