package com.startuppuccino.account;

import javax.validation.Valid;

import java.security.Principal;

import java.time.Instant;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.util.Assert;
import org.springframework.validation.BindingResult;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.ResponseStatus;
import org.springframework.web.bind.annotation.PathVariable;



@Controller
public class AccountController
{
    @Autowired
    private AccountRepository accountRepository;

    @Autowired
    private AccountService accountService;



    @RequestMapping(value = "/login", method = RequestMethod.GET)
    private String login()
    {
        return "account/login";
    }

    @RequestMapping(value = "/registration", method = RequestMethod.GET)
    private String registration(@ModelAttribute Account account)
    {
        return "account/registration";
    }


    @RequestMapping(value = "/registration", method = RequestMethod.POST)
    private String registration(@Valid @ModelAttribute Account account,
                                BindingResult bindingResult)
    {
        account.setRole("ROLE_USER");
        account.setCreated(Instant.now());

        if (bindingResult.hasErrors())
            return "account/registration";

        accountService.save(account);

        accountService.login(account);

        return "redirect:/";
    }





    @RequestMapping(value = "account/current", method = RequestMethod.GET)
    @ResponseStatus(value = HttpStatus.OK)
    @ResponseBody
//    @Secured({"ROLE_USER", "ROLE_ADMIN"})
    public Account currentAccount(Principal principal)
    {
        Assert.notNull(principal);
        return accountRepository.findOneByEmail(principal.getName());
    }


    @RequestMapping(value = "account/{id}", method = RequestMethod.GET)
    @ResponseStatus(value = HttpStatus.OK)
    @ResponseBody
//    @Secured("ROLE_ADMIN")
    public Account account(@PathVariable("id") Long id)
    {
        return accountRepository.findOne(id);
    }

}
