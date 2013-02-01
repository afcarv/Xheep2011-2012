
public class multiplos {

	public static void main(String[]args){
		int n,i=0,resultado=0;
		System.out.println("insira o numero");
		n= User.readInt();
		while(resultado<100 && i<=3){
				resultado=i*n;
			    System.out.println(resultado);
			    i++;
		}
		
	}
}
