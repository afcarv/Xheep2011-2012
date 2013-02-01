import java.lang.Integer;
import java.util.StringTokenizer;

public class Isbn {

	/**
	 * @param args
	 */
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		String ISBN;
		
		System.out.print("introduza o ISBN (os dígitos devem ser separados por um espaço): ");
		ISBN = User.readString();//das o isbn COM ESPAÇOS
		
		StringTokenizer componentes = new StringTokenizer(ISBN); // vai dividir o isbn nos espaços e meter cada token em componentes
		
		String abc = "";
		
		if (componentes.countTokens()<10){//tem de ter 10 numeros
			System.out.println("ISBN inválido");
		}
		while (componentes.hasMoreTokens()){//enquanto componentes tiver mais que uma token vai avançando para a proxima
			abc = abc + componentes.nextToken();}//vai metendo em abc
		
		int numero[] = new int [abc.length()];//array com o tamanho de abc
			
		for(int i=0;i<abc.length()-1;i++){
			Character c = abc.charAt(i);//aqui tens de passar cadaelemento de abc para caracter para poderes depois converter para um numero! O PARSEINT so converte strings! e como nao querias converter abc toda ..vais passar cada elemento por meio de charAt(i) para caracter..depois para String e depois sim usas o parseint para passar para numero e trabalhas sobre ele depois 
			String s = c.toString();
			int n = Integer.parseInt(s); //porque o parse so converte  strings!
			numero[i] = n;//metes os numeros que vais passando no array numero por meio deste ciclo
		}
		
		int para_s1[] = new int [abc.length()];
		int para_s2[] = new int [abc.length()];
		
			for (int y=1; y<9; y++){
			//usando numero que é o array para ISBN
			para_s1[0] = numero[0];
			
				para_s1[y] =  para_s1[y-1] + numero[y];//preenche somas parciais S1
		
			}
			
			for(int k=1; k<10; k++){
			para_s2[0] = numero[0];//preeche somas parciais S2
				para_s2[k] = para_s2[k-1] + para_s1[k];
			}
	
			
		System.out.println("ISBN original: "+ISBN);
		
		System.out.print("somas parciais(s1): ");
		
		for (int m=0; m<para_s1.length; m++){
		System.out.print(para_s1[m] + " ");
		}
		System.out.println();
		System.out.print("somas parciais(s2): ");
		
		for(int n=0; n<para_s2.length; n++){
			System.out.print(para_s2[n] + " ");
		}
		
		System.out.println();
		if ((para_s2[abc.length()-1] % 11) == 0 ){//ve se o ultimo é divisivel por 11 e mostra o resultado
			System.out.println("O ISBN dado é correcto pois"+para_s2[para_s2.length-1]+ "é divisível por 11");
		}
			else{
				System.out.println("O ISBN dado não é válido");
			}
	}
}