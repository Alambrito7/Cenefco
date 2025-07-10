<table class="action" align="center" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table border="0" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td>
<a href="{{ $url }}" 
   class="button button-{{ $color ?? 'primary' }}" 
   target="_blank" 
   rel="noopener"
   style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
          border: none; 
          border-radius: 12px; 
          padding: 15px 35px; 
          text-decoration: none; 
          color: white !important; 
          font-weight: 600; 
          font-size: 16px;
          display: inline-block;
          box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
          transition: all 0.3s ease;">
    {{ $slot }}
</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>