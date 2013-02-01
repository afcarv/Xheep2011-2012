import java.io.*;

public class ex1 
{

	public static void main(String[] args) {
		File f1 = new File ("f91.txt");
		File f2 = new File ("f91.bkp");
		FileReader in;
		FileWriter out;
		
		try{
			in = new FileReader(f1);
			out = new FileWriter(f2);
		
		int c;
		while ((c = in.read()) != -1)
			out.write(c);
		
		
		in.close();
		out.close();
	}
		catch (IOException e){
			System.out.println("Ocorreu uma excepção "+e);
		}
	}
}
