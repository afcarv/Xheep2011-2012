package Ficha3;

import java.util.*;

public class ex3 {
	public static void main(String[] args)
	{
		String line = "";
		String word = "";
		
		System.out.print("linha:");
		line = User.readString();

		System.out.print("palavra:");
		word = User.readString();
		
		//
		StringTokenizer words = new StringTokenizer(line);
		
		
		int count = 0;
		while (words.hasMoreTokens())
		{
			if (word.equals(words.nextToken()))
			{
				count++;
			}	
		}
		
		System.out.println("a palavra " + word + " aparece " + count + " vezes.");
	}
}
