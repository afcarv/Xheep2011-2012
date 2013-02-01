import java.util.Random;

public class ficha02
{	
	//MAIN:
	public static void main (String[] args)
	{
		float[] loriginal = GenerateList(10);
		float[] laverage  = new float[loriginal.length];
		
		PrintList(loriginal);
		
		laverage = AverageList(loriginal);
		
		PrintList(laverage);
	
	}
	//GERA VALORES PARA A LISTA:
	//complete?, untested
	public static float[] GenerateList(int n)
	{
		float[] list = new float[n];
		
		// http://www.cs.geneseo.edu/~baldwin/reference/random.html
		Random rnd = new Random(545446);
		
		for (int i = 0; i < n; i++)
		{
			list[i] = rnd.nextInt(n*10) + 1;		
		}
	
		return list;
	}
	//PRINT LISTA:
	public static void PrintList(float[] list)
	{
		for (int i = 1; i <= list.length; i++)
		{
			System.out.println("point: " + i*10 + " " + list[i-1]);
		}
	}
	//MÉDIA:
	public static float[] AverageList(float[] list)
	{
		boolean straight = false; 

		while (!straight)
		{
			// seeds the delta
			float delta = list[1] - list[0];
			
			straight = true; // reset
			for (int i = 0; i < list.length-1; i++)
			{	
				// see's if we're straigth
				if (delta != (list[i+1] - list[i]))
				{
					straight = false;
					list[i] = list[i]*list[i+1]/2;	
				}
			}
		}
		
		return list;
	}
}