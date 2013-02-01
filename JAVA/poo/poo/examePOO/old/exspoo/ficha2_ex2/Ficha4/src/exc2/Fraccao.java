package exc2;

public class Fraccao {
	public double num;
	public double den;
	
	public Fraccao () {
		num = 1;
		den = 1;
		
		System.out.println("Nao inseriu parametros. A fraccao fica com o valor 1.");
	}
	public Fraccao (double x){
		num = x;
		den = 1;
	}
	public Fraccao (double x, double y) {
		num = x;
		
		if (y!=0){
			den = y;
		}
		else{
			System.out.println("O denominador nao pode ser 0. Foi lhe atribuido o valor 1");
			den = 1;
		}
	}
	
	public String toString() {
		String s1 = String.valueOf(num);
		String s2 = "/";
		String s3 = String.valueOf(den);
		
		return s1 + s2 + s3;
	}
	
	public double getValor () {
		return num/den;
	}
	
	public Fraccao somar (Fraccao f2){
		Fraccao r;
		double x;
		double y;
		
		x = num * f2.den + f2.num * den;
		y = den * f2.den;
		
		if (x%y == 0){
			x = x/y;
			y = 1;
		}
		
		r = new Fraccao(x,y);
		
		return r;
	}
	
	public Fraccao subtrair (Fraccao f2){
		Fraccao f3 = new Fraccao(-1 * f2.num, f2.den);
		
		return this.somar(f3);
	}
	
	public Fraccao multiplicar (Fraccao f2){
		double x = num * f2.num;
		double y = den * f2.den;
		Fraccao r;
		
		if (x%y == 0){
			x = x/y;
			y = 1;
		}
		
		r = new Fraccao (x,y);
		
		return r;
	}
	
	public Fraccao dividir (Fraccao f2){
		Fraccao f3 = new Fraccao (f2.den, f2.num);
		return this.multiplicar(f3);
	}
}
















