
/*public class mainAngulo {

	public static void main(String[] args){
		
	
		Angulo a1 = new Angulo(User.readInt());
		Angulo a2 = new Angulo(User.readInt());
		
		Angulo a3 = new Angulo(a1.adição(a2));//criei um angulo novo a partir de outro angulo, o angulo de entrada é a soma dotros 2
		
		
		System.out.println(a3.cos());
		System.out.println(a3.sin());
		System.out.println(a3.tan());
		
		System.out.println(a3.toString());
		
		if(a1.equals(a3))
			System.out.println("iguais");
	}
}

	
	class Angulo{
		double graus=0;
		public String toString(){
			return "angulo de" +graus+" graus";
		}
		Angulo() {
			graus=0;
			}
		Angulo(double graus) {
			this.graus=graus;
			} //construtores nao têm void nem nada a devolver!
		
		Angulo(Angulo angulo) {
			graus=angulo.graus;
			}
		
		Angulo adição (Angulo angulo){
			Angulo novoAngulo = new Angulo(graus);
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
		boolean equals (Angulo angulo){
			return graus == angulo.graus;
		}
	}*/