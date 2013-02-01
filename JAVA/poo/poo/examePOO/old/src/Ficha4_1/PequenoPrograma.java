package Ficha4_1;


public class PequenoPrograma {

	public static void main(String[] args){
		
	
		AAngulo a1 = new AAngulo(User.readInt());
		AAngulo a2 = new AAngulo(User.readInt());
		
		AAngulo a3 = new AAngulo(a1.adição(a2));//criei um angulo novo a partir de outro angulo, o angulo de entrada é a soma dotros 2
		
		
		System.out.println(a3.cos());
		System.out.println(a3.sin());
		System.out.println(a3.tan());
		
		System.out.println(a3.toString());
		
		if(a1.equals(a3))
			System.out.println("iguais");
	}
}

	
	class AAngulo{
		double graus=0;
		public String toString(){
			return "angulo de" +graus+" graus";
		}
		AAngulo() {
			graus=0;
			}
		AAngulo(double graus) {
			this.graus=graus;
			} //construtores nao têm void nem nada a devolver!
		
		AAngulo(AAngulo angulo) {
			graus=angulo.graus;
			}
		
		AAngulo adição (AAngulo angulo){
			AAngulo novoAngulo = new AAngulo(graus);
			novoAngulo.graus += angulo.graus;
			return novoAngulo;
		}
		double sin(){
			return Math.sin(graus);
		}
		double cos(){ 
			return Math.cos(graus);
			}
		double tan(){
			return Math.tan(graus);
		}
		double radianos(){ 
			return Math.toRadians(graus);
			}
		boolean equals (AAngulo angulo){
			return graus == angulo.graus;
		}
}

