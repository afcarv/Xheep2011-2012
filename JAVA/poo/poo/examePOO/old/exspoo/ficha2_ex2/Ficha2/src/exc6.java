import Common.User;
import Common.lf;


public class exc6 {
	public static void main(String[] args){
		int tam=10;
		double v[] = new double[tam];
		//double v[] = {1,2,3,4,5,6,7,8,9};
		
		int d=1;
		int n=1;
		
		preenche_al (v);
		
		
		System.out.println("Vector antes do alisamento (preenchimento aleatorio): ");
		print_vector(v);
		
		lf.ln();
		
		while (n>0)
		{
			v=alisa(v);
			
			if (n==1) {
			lf.ln();
			
			if (d==1)
				System.out.println("Vector apos alisamento: ");
				
			else
				System.out.println("Vector apos "+d+ "o alisamento: ");
			
			
			print_vector(v);
			
			lf.ln();
			System.out.print("Quer fazer mais quantas iteracoes do algoritmo? ");
			n=User.readInt();
			if (n>0)
				n++;
			}
			
			d++;
			n--;
		}
		
		
		
	}
	
	public static double round (double x, int n_casas){
		long n;
		double p;
		
		p= Math.pow(10, n_casas);
		
		n=Math.round(x * p);
		
		return n / p;
	}
	
	public static void print_vector (double[] v){
		double x;
		
		for (int i=0;i<v.length;i++){
			x = round(v[i],2);
			System.out.print( x +" ");
		}
		
	}
	
	public static double[] preenche_al (double[] v){
		double x;
		
		for (int i=0;i<v.length;i++){
			x = 10 * Math.random();
			v[i]=x;
		}
		
		return v;
	}
	
	public static double[] alisa (double[] v){
		
		for (int i=0;i< v.length -1;i++){
			v[i] = media (v[i],v[i+1]);
		}
		
		v[v.length-1]=media(v[v.length-1],v[v.length-2]);
		
		return v;
		
	}
	
	public static double media (double x1, double x2){
		return ((x1 + x2) / 2);
	}

}
