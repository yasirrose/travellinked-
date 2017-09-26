<html><body>
<html><body>
<table cellpadding="0" cellspacing="0" width="100%" align="center">
    <tr>
        <td>&nbsp;</td>
        <td align="center" width="640">
            <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#f4f4f4">
				<tr>
                    <td height="3" bgcolor="#272D34" colspan="3"></td>
                </tr>
                <tr>
                    <td colspan="3" bgcolor="#272D34">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td height="10" colspan="3"></td>
                            </tr>
                            <tr>
                                <td width="20"></td>
                                <td align="center"><img src="http://travellinked.com/travellinked/assets/images/signup-tl-logo.png">
                                </td>
                                <td width="20"></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="3"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="3" bgcolor="#272D34" colspan="3"></td>
                </tr>
                <tr>
                    <td height="20" colspan="3"></td>
                </tr>
                <tr>
                    <td width="20"></td>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#666666; font-size:16px;">
                        <h2>Hi <?php echo e($data['first_name']); ?> <?php echo e($data['last_name']); ?>,</h2>
                        <p>Thanks for creating an account on Travellinked.
                            Please follow the link below to verify your email address</p>
                    </td>
                    <td width="20"></td>
				</tr>
				<tr>
                    <td height="20" colspan="3"></td>
                </tr>
				<tr>
                    <td width="20"></td>
                    <td align="center">
                            <a href="<?php echo e(URL('verify_email/'.$data['code'])); ?>" style="display: inline-block; color: white; background: #8dcbca;border: 10px solid #8dcbca;font-weight: bold;border-radius: 4px; font-family:Arial, Helvetica, sans-serif; text-decoration:none;">Click to verify the account</a>
                    </td>
                    <td width="20"></td>
				</tr>	
                <tr>
                    
                </tr>
                <tr>
                    <td height="30" colspan="3"></td>
                </tr>
                <tr>
                    <td bgcolor="#272D34" height="10" colspan="3"></td>
                </tr>
                <tr bgcolor="#272D34">
                    <td width="10"></td>
                    <td style="font-family:Arial, Helvetica, sans-serif; color:#ffffff; text-align:center; font-size:15px; line-height:26px;" align="center">&copy; Copyright 2017 Travellinked</td>
                    <td width="10"></td>
                </tr>
                <tr>
                    <td bgcolor="#272D34" height="10" colspan="3"></td>
                </tr>
            </table>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
</body>
</html>

</body>
</html>
