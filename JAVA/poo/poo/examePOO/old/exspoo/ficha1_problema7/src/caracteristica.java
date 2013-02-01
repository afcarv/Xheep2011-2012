
public class caracteristica {
		
public static void main(String[] args) {
	int valor,numero,soma=0,digito;
	System.out.print ("numero: ");
	numero = User.readInt();
	System.out.print ("valor: ");
	valor = User.readInt();
	while (numero>0){
	digito=numero%10;
	soma+=Math.pow(digito, 3);
	numero=numero/10;
	System.out.println ("soma= "+soma);
	}
	if (soma==valor){
	System.out.print("O numero tem caracteristica");
	}
	
}
}