class mainFrac��o{
	
	public static void  main(String[] args){
		
		Frac��o f1= new Frac��o(User.readInt(), User.readInt());
		Frac��o f2 = new Frac��o();
		Frac��o f3=new Frac��o();
		
		f1 = f1.adi��o(f2);
			
		System.out.println(f3.toString());
	}
}
	
	class Frac��o{
		int numerador=1;
		int denominador=1;
		Frac��o() {};
		Frac��o(int n, int d) {numerador = n; denominador = d;}
		
		Frac��o(Frac��o f) {numerador=f.numerador; denominador=f.denominador;}
		
		Frac��o adi��o(Frac��o f){
			return new Frac��o (numerador * f.denominador + f.numerador * denominador, denominador*f.denominador); }
		String toSring() {return "" + numerador + "/" + denominador; }
	}
//subtrac��o, multiplica�ao e divisao
