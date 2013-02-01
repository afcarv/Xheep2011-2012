package Ficha4_2;


public class principal { //vai ser a minha função main é daqui que vou chamar uma outra classe

	public static void main(String[] args) {
		
		int numerador;
		
		System.out.print("introduza o numerador: ");
		numerador = User.readInt();
		
		int denominador;
		System.out.print("introduza o denominador: ");
		denominador=User.readInt();
		
		//um objecto do tipo fracção:
		Fraccao f1 = new Fraccao(numerador,denominador);

		System.out.print("introduza o numerador: ");
		numerador = User.readInt();

		System.out.print("introduza o denominador: ");
		denominador=User.readInt();		
		
		//mais dois objectos do tipo fracção:
		Fraccao f2 = new Fraccao(numerador,denominador);
		Fraccao f3 = new Fraccao();
		
		String deseja;
		System.out.println("o que deseja fazer com f1 e f2?(adicao/subtraccao/multiplicacao/divisao): ");
		deseja = User.readString();
		
		if (deseja.equals("adicao")){
			f3 = f1.adicao(f2);			
			f3.print();
		}
		else if (deseja.equals("subtraccao")){
			f3 = f1.sub(f2);
			f3.print();
		}
		else if (deseja.equals("multiplicacao")){
			f3 = f1.mul(f2);
			f3.print();
		}
		else if (deseja.equals("divisao")){
			f3 = f1.div(f2);
			f3.print();
		}
		else{
			System.out.println("Opção inválida!");
		}
	}
}