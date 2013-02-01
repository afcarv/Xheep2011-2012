
public class ex1
{
	public static void main(String[] args)
	{
		String line = "";
		
		System.out.print("string:");
		line = User.readString();
		
		for (int i = 0; i < line.length()/2; i++)
		{ 
			if (line.charAt(i) != line.charAt(line.length()-(1+i)))
			{
				System.out.println("não é.");
				return;
			}		
		}
		System.out.println("é!");
	}
}


