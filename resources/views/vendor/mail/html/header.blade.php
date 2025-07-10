<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <div style="text-align: center; padding: 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                {{-- Logo CENEFCO --}}
                <img src="{{ asset('images/logo-cenefco.png') }}" 
                     alt="CENEFCO" 
                     style="max-width: 180px; height: auto; margin-bottom: 15px;">
                
                {{-- Nombre de la institución --}}
                <h1 style="color: white; margin: 0; font-size: 20px; font-weight: 700; text-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    {{ $slot }}
                </h1>
                <p style="color: rgba(255,255,255,0.9); margin: 5px 0 0 0; font-size: 12px;">
                    Centro Nacional de Educación y Formación Continua
                </p>
            </div>
        </a>
    </td>
</tr>