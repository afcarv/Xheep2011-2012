package Ficha1;

public class dois {
	public static void main(String[]args){
		System.out.println("vives???");
		
		int soma=0;
		int limite=0;
		
		
		System.out.println("Insira um valor para efeito de limite:");
		limite = User.readInt();
		
		for(int i=1;i<limite;i++){
			soma=soma+i;
			if(soma<=limite){
				System.out.println("A soma é:"+soma);
				
			}
		}
		
	}
}
