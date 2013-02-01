package Ficha1;
public class numerosperfeitos {

public static void main(String[] args) {
	int numero,i,soma=0;
	
	System.out.print("escreva um numero maior que 3: ");
	numero=User.readInt();
	
	for (i=1;i<=numero;i++){
		if (numero%i==0){
			soma+=i;
		}
	}
	if (soma==numero){
		System.out.print("é numero perfeito");}
	else{
		System.out.print("NAO é numero perfeito");
	
	}
	}
	
}