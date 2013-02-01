import Common.User;
import Common.lf;

public class exc13 {
	public static void main (String[] args){
		int x=0;
		
		while (x <1 || x >99){
			System.out.print("x: ");
			x = User.readInt();
			lf.ln();
		}
		
		for (int i=x+1;i<1000;i++)
			if (numero_contido(x,i))
				System.out.println(x+" esta contido em "+i);
		
		
	}
	
	public static boolean numero_contido (int x, int n){
		//Verifica se x esta contido em n, com n>x
		int nd_x=0,b_x=x;
		
		while (x>0){
			nd_x++;
			x/=10;
		}
		
		while (n>0){
			if (b_x == n%Math.pow(10, nd_x))
				return true;
			else
				n /= 10;
		}
		
		return false;
		
	}
}