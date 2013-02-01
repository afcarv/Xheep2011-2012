import java.util.StringTokenizer;

public class Ex5 {
	public static void main(String[] args)
	{
		String isbn = "";
		int s1 = 0, s2 = 0;
		
		System.out.print("isbn (sep. espaços):");
		isbn = User.readString();
		
		StringTokenizer nums = new StringTokenizer(isbn);
		while (nums.hasMoreTokens())
		{
			s1 += Integer.parseInt(nums.nextToken());
			s2 += s1;
		}
		
		if ((s2 % 11) == 0)
		{
			System.out.println("Correcto.");
		}
		else
		{
			System.out.println("Incorrecto");
		}
	}
}
