
public class Fraction { //vai ser a minha função main é daqui que vou chamar uma outra classe

	public static void main(String[] args) {
		
		int numerador;
		System.out.print("introduza o numerador: ");
		numerador = User.readInt();
		int denominador;
		System.out.print("introduza o denominador: ");
		denominador=User.readInt();
		
		
		Fraction2 f1 = new Fraction2(numerador,denominador);

		System.out.print("introduza o numerador: ");
		numerador = User.readInt();

		System.out.print("introduza o denominador: ");
		denominador=User.readInt();		
		
		Fraction2 f2 = new Fraction2(numerador,denominador);
		Fraction2 f3 = new Fraction2();
		
		String deseja;
		System.out.println("o que deseja fazer com f1 e f2?(adicao/subtraccao/multiplicacao/divisao): ");
		deseja = User.readString();
		
		if (deseja.equals("adicao")){
			f3 = f1.adicao(f2);			
			f3.print();
		}
	}
}