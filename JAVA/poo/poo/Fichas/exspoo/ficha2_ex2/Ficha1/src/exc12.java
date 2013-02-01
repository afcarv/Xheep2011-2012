
public class exc12 {
	public static void main(String[] args){
		double x;
		
		for (int i=1; i<=10;i++){
			x = log_bin (i * 100);
			System.out.println("O log bin de "+ (i*100)+" e "+x);
		}
		
	}
	
	public static int log_bin (double n){
		int r=0;
		
		while (n>=2){
			r++;
			n/=2;
		}
		
		return r;
		
	}

}
