
public class capicua {
	public static void main (String[] args){
		int n,r;
		
		System.out.print("Numero: ");
		n = User.readInt();
		
		r = inverte (n);
		
		if (r==n)
			System.out.println(n+" e uma capicua.");
		else
			System.out.println(n+" nao e uma capicua");
		
	}
	
	public static int inverte (int n){
		int r=0;
		
		while (n>0){
			r *= 10;
			r += n%10;
			n /= 10;
		}
		return r;
	}

}
                                          