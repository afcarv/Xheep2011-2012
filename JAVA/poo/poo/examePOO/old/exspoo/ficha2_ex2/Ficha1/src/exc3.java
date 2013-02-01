import Common.User;


public class exc3 {
	public static void main(String[] args){
		int v[];
		int n;
		
		System.out.print("Numero em binario: ");
		n=User.readInt();
		
		v=bin_dec(n);
		
		System.out.println("Numero de 0's: "+v[0]);
		System.out.println("Numero de 1's: "+v[1]);
		System.out.println("Numero em decimal: "+v[2]);
		
		
	}
	
	public static int[] bin_dec (int n){
		int i=0;
		int v[]={0,0,0};
		
		while (n>0){
			v[2] += n%10 * Math.pow(2, i++);
			
			if (n%10 == 0)
				v[0]++;
			else
				v[1]++;
			
			n /= 10;
		}
		
		
		return v;
		
	}

}
