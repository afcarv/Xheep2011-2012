
public class exc5_2 {
	public static void main (String[] args){
		String[] t ={"eer","ola","rac","caa","pur"};
		String p = "car";
		
		
		resolve_qc (t,p);
		
		
	}
	
	public static void resolve_qc (String[] t, String p){
		String i = inversa(p);
		
		System.out.println("A palavra "+p+" surge:");
		verf_h(t,p);
		verf_h(t,i);
		verf_v(t,p);
		verf_v(t,i);
		
	}
	
	public static void verf_v (String[] t, String p){
		String[] t_inv = new String[t[0].length()];
		String s;
		int x=0;
		
		for (int i=0;i< t_inv.length;i++)
			t_inv[i]="";
		
		for (int l=0;l<t.length;l++)
			for (int c=0; c < (t[0].length());c++){
				s=t[l].substring(c,c+1);
				t_inv[c]=t_inv[c].concat(s);
			}
		
		

		for (int i=0;i< t_inv.length;i++){
			x = t_inv[i].indexOf(p);
			
			if (x>=0)
				System.out.println("- Ao longo da coluna "+i+" com inicio na linha "+x);
		}
		
	}
	
	public static String inversa (String p){
		String r="";
		String t;
		
		for (int i=(p.length());i>=1 ;i--){
			t=p.substring(i-1, i);
			r=r.concat(t);
		}
		
		return r;
	}
	
	public static void verf_h (String[] t, String p){
		int x=0;
		
		for (int i=0;i< t.length;i++){
			x = t[i].indexOf(p);
			
			if (x>=0)
				System.out.println("- Ao longo da linha "+i+" com inicio na coluna "+x);
		}
	}
}
