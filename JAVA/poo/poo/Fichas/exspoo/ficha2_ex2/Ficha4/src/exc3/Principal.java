package exc3;

import common.User;

public class Principal {
	public static void main (String[] args){
		Moeda m1= new Moeda(0);
		double r;
		double q;
		
		while (true){
			System.out.print("Quantidade (0 para sair): ");
			q = User.readDouble();
			
			if (q ==0)
				return;
			
			m1.quantidade = q; 
			
			r = m1.converter();
			
			if (r==-1){
				System.out.println("Nao inseriu correctamente o nome das moedas.");
				continue;
			}
			
			System.out.println("O resultado da conversao e " + r);
		}
	}

}
