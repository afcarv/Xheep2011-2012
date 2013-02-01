

public class exc5 {
	public static void main(String[] args){
		char[] p = {'o','l','a'};
		char[][] t = {{'o','l','a','z','o','l','a','r','l','o','s'},{'a','l','o','u','s','x','y','o','o','l','a'}};
		char[][] vert = {{'o','x','z'},{'l','g','h'},{'a','l','o'}};
		
		
		resolve_qc(t,p);
		
	}
	
	public static void resolve_qc (char[][] t, char[] p){
		char[] p_inv = inverte (p);
		
		
		System.out.print("A palavra ");
		for (int i=0;i<p.length;i++)
			System.out.print(p[i]);
		
		System.out.println(" surge:");
			
		s_hor(t,p);
		s_hor (t,p_inv);
		s_ver (t,p);
		s_ver (t,p_inv);
		

		
		
	}
	
	public static void s_ver (char[][] t, char[] p){
		int v;
		
		for (int c=0;c<t[0].length;c++)
			for (int l=0; l < t.length -p.length +1;l++){
				if (p[0]==t[l][c]){
					v=0;
					for (int x=l;x<(p.length+l);x++){
						if (t[x][c] != p[x-c])
							break;
						else
							v++;
					}
					
					if (v==p.length)
						System.out.println("- Ao longo da coluna: "+c+" com inicio na linha "+l);
				}
			}
	}
	
	public static void s_hor (char[][] t, char[] p){
		int v;
		
		for (int l=0;l<t.length;l++)
			for (int c=0;c<(t[0].length - p.length + 1);c++){
				if (p[0]==t[l][c]){
					v=0;
					for (int x=c;x<(p.length+c);x++){
						if (t[l][x]!=p[x-c])
							break;
						else
							v++;
					}
					
					if (v==p.length)
						System.out.println("- Ao longo da linha: "+l+" com inicio na coluna "+c);
				}
			}
		
	}
	
	public static char[] inverte (char[] p){
		char[] r = new char[p.length];
		int j=0;
		
		for (int i=p.length-1;i>=0;i--)
			r[i]=p[j++];
		
		return r;
	}

}
