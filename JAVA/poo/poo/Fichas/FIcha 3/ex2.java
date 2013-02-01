
public class ex2 {
	public static void main(String[] args)
	{
		String line = "";
		
		System.out.print("string:");
		line = User.readString();
		
		for (int i = 0; i < line.length()-1; i++)
		{
			if (isVogal(line.charAt(i)) && isVogal(line.charAt(i+1)))
			{
				line = line.substring(0, i+1) + 'p' + line.substring(i+1);
			}
		}
		System.out.println(line);
	}
	
	public static boolean isVogal(char c)
	{
		char[] vogais = {'a', 'e', 'i', 'o', 'u'};
		
		for (int i = 0; i < vogais.length; i++)
		{
			if (vogais[i] == c)
			{
				return true;
			}
		}
		return false;
	}
}
