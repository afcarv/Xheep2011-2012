import Common.User;
import Common.lf;


public class exc3 {
	public static void main (String[] args){
		int v[];
		int l,j=0,m;
		
		System.out.print("# de numeros: ");
		l=User.readInt();
		
		int r[]= new int[l];
		
		for (int i=0;i<l;i++){
			lf.ln();
			System.out.print("Introduza um numero: ");
			r[j++]=User.readInt();
		}
		
		m = max (r);
		
		v=peneira(m);
		
		
		for (int i=0;i<r.length;i++)
			if (existe(r[i],v))
				System.out.println(r[i]+" e um numero primo");
			else
				System.out.println(r[i]+" nao e uma numero primo");
		
	}
	
	public static boolean existe (int n, int v[]){
		boolean r=false;
		
		for (int i=0;i<v.length;i++)
			if (v[i]==n)
				r=true;
		
		return r;
	}
	
	public static int max (int [] v){
		int m;
		
		m=v[0];
		
		for (int i=1;i<v.length;i++){
			if (v[i]>m)
				m=v[i];
		}
		
		return m;
	}
	
	public static int[] peneira (int n){
		int v[] = new int[n+1];
		int r[] = new int [n];
		int l=0;
		
		
		for (int i=0;i<=n;i++)
			v[i]=1;
		
		for (int i=2;i<=n;i++){
			if (v[i]==1)
				v=el_mul (i,v);
		}
		
		for (int i=2;i<=n;i++){
			if (v[i]==1)
				r[l++]=i;
		}
		
		
		return r;
	}
	
	public static int[] el_mul (int n, int[] v){
		int m;
		
		for (int i=2;;i++){
			m=n*i;
			
			if (m<v.length)
				v[m]=0;
			else
				break;
		}
		
		return v;
	}

}
